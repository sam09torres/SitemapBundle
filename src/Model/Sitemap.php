<?php


namespace Christiana\SitemapBundle\Model;


class Sitemap
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var UrlSet
     */
    private UrlSet $urlSet;

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Sitemap
     */
    public function setPath(string $path): Sitemap
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return UrlSet
     */
    public function getUrlSet(): UrlSet
    {
        return $this->urlSet;
    }

    /**
     * @param UrlSet $urlSet
     * @return Sitemap
     */
    public function setUrlSet(UrlSet $urlSet): Sitemap
    {
        $this->urlSet = $urlSet;
        return $this;
    }
}
