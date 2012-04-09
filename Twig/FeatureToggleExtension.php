<?php
namespace Emka\FeatureToggleBundle\Twig;

/**
 * This is the main extension file enabling feature toggling
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-17
 */

use Emka\FeatureToggleBundle\Twig\FeatureToggleTokenParser;
use Emka\FeatureToggleBundle\Feature\FeatureManager;

class FeatureToggleExtension extends \Twig_Extension
{
    protected $manager;

    public function __construct(FeatureManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return FeatureManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    public function getTokenParsers()
    {
        return array(new FeatureToggleTokenParser($this->getManager()));
    }

    public function getFilters()
    {
        return array();
    }

    public function getName()
    {
        return 'featuretoggle';
    }
}
