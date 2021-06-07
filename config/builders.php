<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Christiana\SitemapBundle\Builder\Builder;
use Christiana\SitemapBundle\Builder\BuilderInterface;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set('christiana_sitemap.builder', Builder::class)
        ->args([
            [
                service('christiana_sitemap.normalizer.sitemap'),
                service('christiana_sitemap.normalizer.sitemap_index'),
            ],
            [
                service('christiana_sitemap.encoder.xml'),
                service('christiana_sitemap.encoder.text'),
            ]
        ])
    ;

    $services->alias(BuilderInterface::class, 'christiana_sitemap.builder');
};
