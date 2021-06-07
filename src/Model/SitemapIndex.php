<?php


namespace Christiana\SitemapBundle\Model;


use Symfony\Component\Serializer\Annotation\SerializedName;

class SitemapIndex
{
    /**
     * @var Sitemap[]
     * @SerializedName("sitemap")
     */
    private array $sitemaps = [];

    /**
     * @return Sitemap[]
     */
    public function getSitemaps(): array
    {
        return $this->sitemaps;
    }

    /**
     * @param Sitemap[] $sitemaps
     * @return SitemapIndex
     */
    public function setSitemaps(array $sitemaps): SitemapIndex
    {
        $this->sitemaps = $sitemaps;
        return $this;
    }

    public function addSitemap(Sitemap $sitemap): SitemapIndex
    {
        $this->sitemaps[] = $sitemap;
        return $this;
    }
}
