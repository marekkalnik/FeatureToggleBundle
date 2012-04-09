<?php
namespace Emka\FeatureToggleBundle\Feature;

/**
 * FeatureManager class.
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */

class FeatureManager implements \ArrayAccess
{
    protected $features;

    public function __construct(array $features = array())
    {
        $this->features = $features;
    }

    /**
     * @param $feature
     */
    public function add($feature)
    {
        $this->offsetSet($feature->getName(), $feature);
    }

    /**
     * @param $featureName
     * @return bool
     */
    public function has($featureName)
    {
        return $this->offsetExists($featureName);
    }

    /**
     * @param $featureName
     * @return Feature
     */
    public function get($featureName)
    {
        return $this->offsetGet($featureName);
    }

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset
     * @return boolean Returns true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return isset($this->features[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->features[$offset] : null;
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->features[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->features[$offset]);
    }

}
