<?php

namespace Translation\PlatformAdapter\Doctrine\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Yenkong Lybliamay <yenkong@lybliamay.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('translation_adapter_doctrine');

        return $treeBuilder;
    }
}
