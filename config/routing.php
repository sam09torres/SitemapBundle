<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Christiana\SitemapBundle\Generator\GeneratorInterface;
use Christiana\SitemapBundle\Routing\RouteLoader;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set('christiana_sitemap.routing.route_loader', RouteLoader::class)
        ->args([
            service(GeneratorInterface::class),
        ])
        ->tag('routing.loader')
        ->tag('routing.route_loader')
    ;

};
