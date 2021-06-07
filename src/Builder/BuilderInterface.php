<?php


namespace Christiana\SitemapBundle\Builder;


use Christiana\SitemapBundle\Model\Sitemap;
use Christiana\SitemapBundle\Model\SitemapIndex;

interface BuilderInterface
{

    /**
     * @param SitemapIndex $index
     * @return string
     */
    public function buildIndex(SitemapIndex $index, string $format, bool $all = false): string;

    /**
     * @param Sitemap $sitemap
     * @return string
     */
    public function buildSitemap(Sitemap $sitemap, string $format): string;
}
