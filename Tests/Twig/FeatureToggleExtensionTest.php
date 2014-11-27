<?php
namespace Emka\FeatureToggleBundle\Test\Twig;

use Emka\FeatureToggleBundle\Feature\Feature;
use Emka\FeatureToggleBundle\Feature\FeatureManager;
use Emka\FeatureToggleBundle\Twig\FeatureToggleExtension;

class FeatureToggleExtensionTest extends \PHPUnit_Framework_TestCase
{

    public function testIsEnabled()
    {
        $feature = new Feature('test', false);
        $manager = new FeatureManager(array('test' => $feature));

        $extension = new FeatureToggleExtension($manager);

        $this->assertFalse($extension->isEnabled('test'));
    }

    /**
     * @expectedException \Emka\FeatureToggleBundle\Exception\FeatureToggleNotFoundException
     */
    public function testException()
    {
        $feature = new Feature('test', false);
        $manager = new FeatureManager(array('test' => $feature));

        $extension = new FeatureToggleExtension($manager);

        $this->assertFalse($extension->isEnabled('nono'));
    }
} 