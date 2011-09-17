<?php

/**
 * This is the main extension file enabling feature toggling
 * 
 * @author Marek Kalnik <marekk@theodo.fr>
 * @since  2011-09-17
 */
class Twig_Extensions_Extension_FeatureToggle extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Twig_Extensions_TokenParser_FeatureToggle(),
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