<?php


namespace Christiana\SitemapBundle\Provider;


use Christiana\RssBundle\Model\Channel;
use Christiana\SitemapBundle\Model\UrlSet;

interface SitemapProviderInterface
{
    const TAG = 'christiana_rss.sitemap_provider';

    /**
     * @return Channel
     */
    public function build(UrlSet $set): void;
}
