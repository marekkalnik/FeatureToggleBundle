<?php
namespace Emka\FeatureToggleBundle\Tests\DependencyInjection;

use Symfony\Bundle\AsseticBundle\DependencyInjection\AsseticExtension;
use Symfony\Bundle\AsseticBundle\DependencyInjection\Compiler\CheckYuiFilterPass;
use Symfony\Bundle\AsseticBundle\DependencyInjection\Compiler\CheckClosureFilterPass;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\HttpFoundation\Request;
use Emka\FeatureToggleBundle\Feature\Feature;
use Emka\FeatureToggleBundle\Feature\FeatureManager;

/**
 * Semantic feature toggling configuration.
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-20
 */
class FeatureToggleExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $kernel;
    private $container;

    static public function assertSaneContainer(Container $container, $message = '')
    {
        $errors = array();
        foreach ($container->getServiceIds() as $id) {
            try {
                $container->get($id);
            } catch (\Exception $e) {
                $errors[$id] = $e->getMessage();
            }
        }

        self::assertEquals(array(), $errors, $message);
    }

    protected function setUp()
    {
        $this->kernel = $this->getMock('Symfony\\Component\\HttpKernel\\KernelInterface');

        $this->container = new ContainerBuilder();
        $this->container->addScope(new Scope('request'));
        $this->container->register('request', 'Symfony\\Component\\HttpFoundation\\Request')->setScope('request');
        $this->container->register('templating.helper.assets', $this->getMockClass('Symfony\\Component\\Templating\\Helper\\AssetsHelper'));
        $this->container->register('templating.helper.router', $this->getMockClass('Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper'))
            ->addArgument(new Definition($this->getMockClass('Symfony\\Component\\Routing\\RouterInterface')));
        $this->container->register('twig', 'Twig_Environment');
        $this->container->setParameter('kernel.bundles', array());
        $this->container->setParameter('kernel.cache_dir', __DIR__);
        $this->container->setParameter('kernel.debug', false);
        $this->container->setParameter('kernel.root_dir', __DIR__);
        $this->container->setParameter('kernel.charset', 'UTF-8');
        $this->container->set('kernel', $this->kernel);
    }

    public function testDefaultConfig()
    {
        $extension = new \Emka\FeatureToggleBundle\DependencyInjection\FeatureToggleExtension();
        $extension->load(array(array()), $this->container);

        $this->assertFalse($this->container->has('feature_toggle.features'));
    }

    public function testConfig()
    {
        $extension = new \Emka\FeatureToggleBundle\DependencyInjection\FeatureToggleExtension();
        $extension->load(array(array(
            'features' => array(
                'test_enabled' => array(
                    'name' => 'test_enabled',
                    'enabled' => true,
                ),
                'test_disabled' => array(
                    'name' => 'test_disabled',
                    'enabled' => false,
                )
            )
        )), $this->container);

        $this->assertTrue($this->container->has('feature_toggle.features.test_enabled'));
        $this->assertTrue($this->container->has('feature_toggle.features.test_disabled'));

    }
}
