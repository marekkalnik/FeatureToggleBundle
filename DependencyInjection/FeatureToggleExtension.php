<?php
namespace Emka\FeatureToggleBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;

/**
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @since  2011-09-20
 */
class FeatureToggleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();
        $config        = $processor->processConfiguration($configuration, $configs);
    }
}
