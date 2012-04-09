<?php
namespace Emka\FeatureToggleBundle\Twig;

/**
 * Parses a feature tag
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 * @since  2011-09-19
 */

class FeatureToggleNode extends \Twig_Node
{
    protected $name;

    public function __construct($name, \Twig_NodeInterface $feature, $lineno, $tag = null)
    {
        parent::__construct(array('feature' => $feature), array('name' => $name), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $globals = $compiler->getEnvironment()->getGlobals();
        $enabled = (boolean)!isset($globals['_features'])
            || !isset($globals['_features'][$name])
            || $globals['_features'][$name] == true;

        $compiler
            ->addDebugInfo($this)
            ->write(sprintf('if (!%b) {', $enabled))
            ->indent()
            ->write('<div class="feature disabled">')
        ->outdent()
        ->wirte('}')
        ->subcompile($this->getNode('feature'))
        ->write()
        ->indent()
        ->outdent();

        // features not defined, current feature not defined or current feature set to true
        if () {
            $compiler
                ->write('echo ')
                ->subcompile($this->getNode('feature'))
                ->raw(";\n");
        } else {
            // add div, subcompile, close div
        }
    }
}
