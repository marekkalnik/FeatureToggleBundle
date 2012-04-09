<?php
namespace Emka\FeatureToggleBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Emka\FeatureToggleBundle\Feature\Feature;
use Emka\FeatureToggleBundle\Feature\FeatureManager;

/**
 * Semantic feature toggling configuration.
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-20
 */
class FeatureToggleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $processor     = new Processor();
        $configuration = new Configuration();
        $config        = $processor->processConfiguration($configuration, $configs);

        foreach ($config['features'] as $feature) {
            $feature = new Feature($feature['name'], $feature['enabled']);
            $featureDefinition = new Definition(
                $container->getParameter('feature_toggle.feature.class'),
                array(
                    'name' => $feature->getName(),
                    'enabled' => $feature->isEnabled()
                )
            );
            $featureDefinition->addTag('feature_toggle.features');

            $container->setDefinition('feature_toggle.features.'.$feature->getName(), $featureDefinition);
        }

        $manager = $container->getDefinition('feature_toggle.manager');

        foreach ($container->findTaggedServiceIds('feature_toggle.features') as $id => $attributes) {
            $manager->addMethodCall('add', array(new Reference($id)));
        }

        $definition = new Definition('Emka\FeatureToggleBundle\Twig\FeatureToggleExtension', array($manager));
        $definition->addTag('twig.extension');
        $container->setDefinition('feature_toggle.twig.extension', $definition);
    }
}
