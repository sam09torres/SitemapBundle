<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use Christiana\SitemapBundle\Controller\SitemapController;
use Christiana\SitemapBundle\Generator\GeneratorInterface;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set(SitemapController::class, SitemapController::class)
        ->args([
            service(GeneratorInterface::class),
        ])
        ->tag('controller.service_arguments')
        ->call('setContainer',[service('service_container')])
        ->public()
    ;

};
