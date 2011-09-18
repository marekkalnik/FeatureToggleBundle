<?php
class Twig_Extensions_Node_FeatureToggle extends Twig_Node
{
    public function __construct($name, Twig_NodeInterface $feature, $lineno, $tag = null)
    {
        parent::__construct(array('feature' => $feature), array('name' => $name), $lineno, $tag);
    }
    
    public function compile(Twig_Compiler $compiler)
    {
    	$globals = $compiler->getEnvironment()->getGlobals();
    	$enabled = (boolean) !isset($globals['_features']) 
    		|| !isset($globals['_features'][$name])
    		|| $globals['_features'][$name] == true;
    	
    	$compiler
    		->addDebugInfo($this)
    		->write(sprintf('if (!%b) {', $enabled))
    		->indent()
    			->write('<div class="feature disabled">'))
    		->outdent()
    		->wirte('}')
    		->subcompile($this->getNode('feature'))
    		->write()
    		->indent()
    		->outdent()
    		
    		
    	
    	
    	
    	// features not defined, current feature not defined or current feature set to true
    	if ()
    	{
    		$compiler
    			->write('echo ')
    			->subcompile($this->getNode('feature'))
    			->raw(";\n");
       	} else {
       		// add div, subcompile, close div
       	}
    }
}