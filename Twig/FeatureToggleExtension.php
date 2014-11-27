<?php
namespace Emka\FeatureToggleBundle\Twig;

/**
 * This is the main extension file enabling feature toggling
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-17
 */

use Emka\FeatureToggleBundle\Exception\FeatureToggleNotFoundException;
use Emka\FeatureToggleBundle\Feature\FeatureManager;

/**
 * Class FeatureToggleExtension
 * @package Emka\FeatureToggleBundle\Twig
 */
class FeatureToggleExtension extends \Twig_Extension
{
    /**
     * @var FeatureManager
     */
    protected $manager;

    /**
     * @param FeatureManager $manager
     */
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

    /**
     * @return array
     */
    public function getTokenParsers()
    {
        return array(new FeatureToggleTokenParser($this->getManager()));
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('feature_enabled', [$this, 'isEnabled']),
        );
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * @param $name
     * @return bool
     * @throws FeatureToggleNotFoundException
     */
    public function isEnabled($name)
    {
        if (!$this->manager->has($name)) {
            throw new FeatureToggleNotFoundException(sprintf('The feature "%s" does not exist.', $name));
        } else {
            $feature = $this->manager->get($name);
        }

        return $feature->isEnabled();
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'featuretoggle';
    }
}
