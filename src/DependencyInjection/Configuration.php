<?php


namespace Christiana\SitemapBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('christiana_sitemap');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('locales')
                    ->info('Array of locales in order to generate urls, the default locale is added automatically')
                    ->scalarPrototype()
                        ->example(['fr','en'])
                    ->end()
                    ->defaultValue([])
                ->end()
                ->booleanNode('enable_index')
                    ->info('If true, sitemaps will be created individually with an sitemap index file. If false, a single
                    sitemap will be created. If so, ensure to set the \'index_path\'')
                    ->defaultTrue()
                ->end()
                ->scalarNode('index_path')
                    ->info('Defines the path to the index sitemap. Used if \'enable_index\' has been set to true (Default is true)')
                    ->defaultValue('/sitemap.xml')
                    ->example('/sitemap.xml')
                ->end()
                ->enumNode('default_format')
                    ->info('This is the format used to format sitemaps')
                    ->defaultValue('xml')
                    ->values(['xml','rss','txt'])
                ->end()
                ->append($this->addFormats([
                    'xml' => ['mime_type' => 'application/xml'],
                    'rss' => ['mime_type' => 'application/rss+xml'],
                    'txt' => ['mime_type' => 'text/plain'],
                ]))
                ->arrayNode('sitemaps')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('provider')
                                ->isRequired()
                            ->end()
                            ->scalarNode('route_path')
                                ->example('/example.sitemap.xml')
                                ->defaultNull()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addFormats($defaults)
    {
        $treeBuilder = new TreeBuilder('formats');
        $node = $treeBuilder->getRootNode()
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->scalarPrototype()->isRequired()->end()
        ;

        return $node;

    }
}
