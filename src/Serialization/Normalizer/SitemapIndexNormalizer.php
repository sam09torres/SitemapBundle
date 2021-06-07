<?php


namespace Christiana\SitemapBundle\Serialization\Normalizer;


use Christiana\RssBundle\Model\Channel;
use Christiana\SitemapBundle\Model\Sitemap;
use Christiana\SitemapBundle\Model\SitemapIndex;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class SitemapIndexNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'SITEMAP_INDEX_ALREADY_CALLED';

    /**
     * @param SitemapIndex $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        if($format === 'xml')
        {
            if($context['enable_index'])
            {
                return [
                    'sitemap' => array_map(function (Sitemap $sitemap) use(&$format) {
                        return ['loc' => $sitemap->getPath().'.'.$format];
                    }, $object->getSitemaps()),
                ];
            }else{
                $data = [];

                foreach ($object->getSitemaps() as $sitemap)
                {
                    foreach ($sitemap->getUrlSet()->getUrls() as $url){
                        $data['url'][] = $url;
                    }
                }

                return $data;
            }
        }

        if($format === 'txt')
        {
            return array_map(function (Sitemap $sitemap) use(&$format) {
                return $sitemap->getPath().'.'.$format;
            }, $object->getSitemaps());
        }

        return $this->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof SitemapIndex;
    }

}
