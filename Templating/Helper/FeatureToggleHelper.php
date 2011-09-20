<?php
namespace Emka\FeatureToggleBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class FeatureToggleHelper extends Helper
{
	protected $features;
	
	public function __construct($features_config)
	{
		$features = array();
		foreach ($features as $feature_config)
		{
			$features[$feature_config['name']] = $feature_config['enabled'];
		}
		
		$this->features = $features;
	}
	
	public function startToggle($feature_name)
	{
	  if ($this->isHidden($feature_name))
	  {
	    $tag = '<div class="feature-toggle">';
	    
	    return $tag;
	  }
	}
	
	/**
	 * Ferme le tag de feature toggle
	 *
	 * @see    feature_toggle
	 */
	public function endToggle($feature_name)
	{
	  if ($this->isHidden($feature_name))
	  {
	    return '</div>';
	  }
	}
	
	protected function isHidden($feature_name)
	{
	  return isset($this->features[$feature_name]) && !$this->features[$feature_name];
	}
	
	public function getName() {
		return 'feature_toggle';
	}
}