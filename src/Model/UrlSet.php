<?php


namespace Christiana\SitemapBundle\Model;


use Symfony\Component\Serializer\Annotation\SerializedName;

class UrlSet
{
    /**
     * @var Url[]
     * @SerializedName("url")
     */
    private array $urls = [];

    /**
     * @return Url[]
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * @param Url[] $urls
     * @return UrlSet
     */
    public function setUrls(array $urls): UrlSet
    {
        $this->urls = $urls;
        return $this;
    }


}
