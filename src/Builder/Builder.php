<?php


namespace Christiana\SitemapBundle\Builder;


use Christiana\RssBundle\Model\Channel;
use Christiana\SitemapBundle\Model\Sitemap;
use Christiana\SitemapBundle\Model\SitemapIndex;
use Christiana\SitemapBundle\Serialization\Normalizer\SitemapIndexNormalizer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Builder implements BuilderInterface
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    public function __construct(
        array $normalizers,
        array $encoders,
    )
    {
        $normalizers[] = new ObjectNormalizer();
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @inheritDoc
     */
    public function buildIndex(SitemapIndex $index, string $format, $all = false): string
    {
        return $this->serialize($index, $format, $all);
    }

    public function buildSitemap(Sitemap $sitemap, string $format): string
    {
        return $this->serialize($sitemap, $format);
    }



    /**
     * @param SitemapIndex|Sitemap $data
     * @return string
     */
    private function serialize($data, $format, $all = false)
    {
        if($data instanceof SitemapIndex && !$all)
        {
            $rootName = 'sitemapindex';
        }else{
            $rootName = 'urlset';
        }

        return $this->serializer->serialize($data, $format, [
            XmlEncoder::FORMAT_OUTPUT => true,
            XmlEncoder::VERSION => '1.0',
            XmlEncoder::ENCODING => 'utf-8',
            XmlEncoder::ROOT_NODE_NAME => $rootName,
            XmlEncoder::AS_COLLECTION => true,
            XmlEncoder::REMOVE_EMPTY_TAGS => true,
            'enable_index' => !$all,
        ]);
    }
}
