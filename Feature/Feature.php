<?php
namespace Emka\FeatureToggleBundle\Feature;

/**
 * Feature class.
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */

class Feature implements FeatureInterface
{
    protected $name,
              $isEnabled;

    /**
     * @param string $name
     * @param string $isEnabled
     */
    public function __construct($name, $isEnabled)
    {
        $this->name = $name;
        $this->isEnabled = $isEnabled;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isEnabled === true;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
