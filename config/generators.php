<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Christiana\SitemapBundle\Builder\BuilderInterface;
use Christiana\SitemapBundle\Generator\Generator;
use Christiana\SitemapBundle\Generator\GeneratorInterface;
use Christiana\SitemapBundle\Provider\SitemapProviderInterface;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set('christiana_sitemap.generator', Generator::class)
        ->args([
            service('router.default'),
            service(BuilderInterface::class),
        ])
        ->call('setProviders', [tagged_iterator(SitemapProviderInterface::TAG)])
    ;

    $services->alias(GeneratorInterface::class, 'christiana_sitemap.generator');
};
