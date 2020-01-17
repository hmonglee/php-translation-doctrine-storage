<?php

declare(strict_types=1);

namespace Translation\PlatformAdapter\Doctrine\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
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
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
    }
}
