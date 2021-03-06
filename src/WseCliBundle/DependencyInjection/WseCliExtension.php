<?php

namespace WseCliBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * WseCliExtension.
 *
 * @author Brian Slezak <brian@theslezaks.com>
 */
class WseCliExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(dirname(__DIR__).'/Resources/config');
        $yamlFileLoader = new YamlFileLoader($container, $fileLocator);
        $yamlFileLoader->load('config.yml');

        $processor = new Processor();
        $processedConfig = $processor->processConfiguration(new Configuration(), $configs);

        // Injecting stream_recorder settings into StreamRecorder service
        $definition = $container->getDefinition('wse_cli.stream_recorder');
        $definition->addMethodCall('setDefaults', [
            $processedConfig['stream_recorder'],
        ]);
    }
}
