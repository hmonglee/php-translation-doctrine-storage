<?php

namespace Translation\PlatformAdapter\Doctrine\Bridge\Symfony\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Translation\PlatformAdapter\Doctrine\Doctrine;

/**
 * @author Yenkong Lybliamay <yenkong@lybliamay.fr>
 */
class TranslationAdapterDoctrineExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $adapterDef = $container->register('php_translation.adapter.doctrine');
        $adapterDef->setClass(Doctrine::class)
            ->setPublic(true);
    }
}
