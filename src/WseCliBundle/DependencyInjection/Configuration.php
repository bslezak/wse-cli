<?php
namespace WseCliBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 * @author bslezak <brian@theslezaks.com>
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
        d("reached\n");
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wse_cli');
        $rootNode->children()
            ->arrayNode('stream_recorder')
            ->canBeDisabled()
            ->children()
            ->scalarNode('instanceName')
            ->end()
            ->scalarNode('fileVersionDelegateName')
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}