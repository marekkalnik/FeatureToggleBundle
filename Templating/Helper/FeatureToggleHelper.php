<?php
namespace Emka\FeatureToggleBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

/**
 * Helper that is used to inject html tags into code,
 * to wrap it with the correct css class
 * 
 * @author Marek Kalnik <kalnik.marek@gmail.com>
 * @since  2011-11
 */
class FeatureToggleHelper extends Helper
{

    protected $features;

    /**
     * @param Array $featuresConfig An array containing 'name' and 'enabled' parameters
     */
    public function __construct($featuresConfig)
    {
        $features = array();
        foreach ($featuresConfig as $feature) {
            $features[$feature['name']] = $feature['enabled'];
        }

        $this->features = $features;
    }

    /**
     * If feature is set to hidden: wraps it with "feature-toggle" css class
     * 
     * @param  String $featureName
     * @return String 
     */
    public function startToggle($featureName)
    {
        if ($this->isHidden($featureName)) {
            return '<div class="feature-toggle">';
        }
    }

    /**
     * Closes the wrapping div, if features is hidden
     * 
     * @return String
     */
    public function endToggle($featureName)
    {
        if ($this->isHidden($featureName)) {
            return '</div>';
        }
    }

    /**
     * Checks feature config to see if it's disabled
     *
     * @param  String $featureName
     * @return Boolean
     */
    protected function isHidden($featureName)
    {
        return isset($this->features[$featureName]) && !$this->features[$featureName];
    }

    /**
     * Return helper's name for symfony internals
     * 
     * @return String 
     */
    public function getName()
    {
        return 'feature_toggle';
    }
}