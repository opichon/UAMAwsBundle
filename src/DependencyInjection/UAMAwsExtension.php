<?php

namespace UAM\Bundle\AwsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class UAMAwsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'uam_aws.config',
            array_key_exists('config_path', $config)
                ? $config['config_path']
                : $config['config']
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('common.yml');
        $loader->load('s3.yml');
        $loader->load('sqs.yml');
    }
}
