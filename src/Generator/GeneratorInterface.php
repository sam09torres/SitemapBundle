<?php


namespace Christiana\SitemapBundle\Generator;


interface GeneratorInterface
{
    public function generateIndex(?string $format = null): string;

    public function generateSitemap(string $sitemapName, ?string $format = null): string;

}
