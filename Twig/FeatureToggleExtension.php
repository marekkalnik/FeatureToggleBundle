<?php
namespace Emka\Twig;
/**
 * This is the main extension file enabling feature toggling
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @since  2011-09-17
 */

use \Emka\Twig\FeatureToggleTokenParser;

class FeatureToggleExtension extends \Twig_Extension
{
    public function getTokenParsers()
    {
        return array(
            new FeatureToggleTokenParser(),
        );
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
