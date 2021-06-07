<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Christiana\SitemapBundle\Serialization\Encoder\TextEncoder;
use Christiana\SitemapBundle\Serialization\Encoder\XmlEncoder;
use Christiana\SitemapBundle\Serialization\Normalizer\SitemapIndexNormalizer;
use Christiana\SitemapBundle\Serialization\Normalizer\SitemapNormalizer;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $normalizers = [
        'christiana_sitemap.normalizer.sitemap' => SitemapNormalizer::class,
        'christiana_sitemap.normalizer.sitemap_index' => SitemapIndexNormalizer::class,
    ];

    $encoders = [
        'christiana_sitemap.encoder.xml' => XmlEncoder::class,
        'christiana_sitemap.encoder.text' => TextEncoder::class,
    ];

    foreach ($normalizers as $id => $fqcn)
    {
        $services
            ->set($id,$fqcn)
            ->tag('serializer.normalizer')
        ;
    }

    foreach ($encoders as $id => $fqcn)
    {
        $services
            ->set($id,$fqcn)
            ->tag('serializer.encoder')
        ;
    }
};
