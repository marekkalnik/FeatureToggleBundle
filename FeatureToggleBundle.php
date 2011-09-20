<?php
namespace Emka\FeatureToggleBundle;

use Emka\FeatureToggleBundle\DependencyInjection\Compiler\FeaturesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Feature toggling for Symfony2
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 * @since  2011-09-19
 */
class FeatureToggleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
