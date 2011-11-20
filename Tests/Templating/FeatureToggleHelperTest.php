<?php
namespace Emka\FeatureToggleBundle\Test\Templating;

use Emka\FeatureToggleBundle\Templating\Helper\FeatureToggleHelper;

class FeatureToggleHelperTest extends \PHPUnit_Framework_TestCase
{
	public function testDisabledFeature() {
		$helper = new FeatureToggleHelper(array(
			'name' => 'test',
			'enabled' => false,
		));
		
		$this->assertEquals(
			'<div class="feature-toggle">',
			$helper->startToggle('test')
		);
		
		$this->assertEquals(
			'</div">',
			$helper->endToggle('test')
		);
	}	
}