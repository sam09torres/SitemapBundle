<?php


namespace Christiana\SitemapBundle\DependencyInjection;


use Christiana\RssBundle\Feed\FeedProviderInterface;
use Christiana\SitemapBundle\Provider\SitemapProviderInterface;
use Christiana\SitemapBundle\SitemapService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class ChristianaSitemapExtension extends ConfigurableExtension
{
    const PROVIDER_INTERFACE_TAG = 'christiana.sitemap.sitemap_provider';

    public function getNamespace()
    {
        return 'http://christiana.org/schema/dic/'.$this->getAlias();
    }

    public function getAlias()
    {
        return 'christiana_sitemap';
    }

    /**
     * @inheritDoc
     */
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        $this->registerProviders($container);
        $this->loadServices($config, $container);

    }

    private function registerProviders(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(SitemapProviderInterface::class)
            ->addTag(SitemapProviderInterface::TAG);
    }


    /**
     * @inheritDoc
     */
    private function loadServices(array $config, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(
            __DIR__.'/../../config'
        ));

        $resources = [
            'serialization',
            'builders',
            'generators',
            'controllers',
            'routing',
        ];

        foreach($resources as $resource)
        {
            $loader->load($resource.'.php');
        }

        $container->getDefinition('christiana_sitemap.generator')
            ->addMethodCall('setSitemaps',[$config['sitemaps']])
            ->addMethodCall('setLocales',[$config['locales']])
            ->addMethodCall('setEnableIndex',[$config['enable_index']])
            ->addMethodCall('setIndexPath',[$config['index_path']])
            ->addMethodCall('setDefaultFormat',[$config['default_format']])
            ->addMethodCall('setFormats',[$config['formats']])
        ;
    }

}
