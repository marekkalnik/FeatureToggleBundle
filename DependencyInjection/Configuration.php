<?php
namespace Emka\FeatureToggleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('feature_toggle');

        $rootNode
            ->children()
                ->arrayNode('features')
                	->canBeUnset()
                	->treatTrueLike()
                	->children()
                		->scalarNode('name')->defaultValue('')->end()
                		->booleanNode('enabled')->defaultValue(true)->end()
                	->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}