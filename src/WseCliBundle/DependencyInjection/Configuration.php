<?php
namespace WseCliBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 * Configuration
 *
 * @author Brian Slezak <brian@theslezaks.com>
 * @version @application_version@
 *
 */
class Configuration implements ConfigurationInterface
{

    /**
     *
     * {@inheritdoc}
     *
     * @see \Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration::getConfigTreeBuilder()
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wse_cli');
        $rootNode->children()
            ->arrayNode('stream_recorder')
            ->canBeDisabled()
            ->children()
            ->scalarNode('instanceName')
            ->defaultValue("")
            ->end()
            ->scalarNode('fileVersionDelegateName')
            ->defaultValue("")
            ->end()
            ->scalarNode('recorderName')
            ->info("recorderName must match the name of the incoming stream!")
            ->cannotBeEmpty()
            ->end()
            ->integerNode("currentSize")
            ->defaultValue(0)
            ->end()
            ->scalarNode("segmentSchedule")
            ->defaultValue("")
            ->end()
            ->booleanNode("startOnKeyFrame")
            ->defaultTrue()
            ->end()
            ->scalarNode("outputPath")
            ->defaultValue("")
            ->end()
            ->scalarNode("currentFile")
            ->defaultValue("")
            ->end()
            ->arrayNode("saveFieldList")
            ->children()
            ->end()
            ->end()
            ->booleanNode("recordData")
            ->defaultFalse()
            ->end()
            ->scalarNode("applicationName")
            ->cannotBeEmpty()
            ->info("applicationName is the name of the WSE application where the incoming stream is located")
            ->end()
            ->booleanNode("moveFirstVideoFrameToZero")
            ->defaultFalse()
            ->end()
            ->scalarNode("recorderErrorString")
            ->defaultValue("")
            ->end()
            ->integerNode("segmentSize")
            ->defaultValue(0)
            ->end()
            ->booleanNode("defaultRecorder")
            ->defaultFalse()
            ->end()
            ->booleanNode("splitOnTcDiscontinuity")
            ->defaultFalse()
            ->end()
            ->scalarNode("version")
            ->defaultValue("")
            ->end()
            ->scalarNode("baseFile")
            ->defaultValue("")
            ->end()
            ->integerNode("segmentDuration")
            ->defaultValue(0)
            ->end()
            ->scalarNode("recordingStartTime")
            ->defaultValue("")
            ->end()
            ->scalarNode("fileTemplate")
            ->defaultValue("")
            ->end()
            ->integerNode("backBufferTime")
            ->defaultValue(0)
            ->end()
            ->scalarNode("segmentationType")
            ->defaultValue("")
            ->end()
            ->integerNode("currentDuration")
            ->defaultValue(0)
            ->end()
            ->scalarNode("fileFormat")
            ->defaultValue("")
            ->end()
            ->scalarNode("recorderState")
            ->defaultValue("")
            ->end()
            ->scalarNode("option")
            ->defaultValue("")
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}