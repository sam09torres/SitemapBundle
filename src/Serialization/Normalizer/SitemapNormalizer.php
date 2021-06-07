<?php


namespace Christiana\SitemapBundle\Serialization\Normalizer;


use Christiana\RssBundle\Model\Channel;
use Christiana\SitemapBundle\Model\Sitemap;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class SitemapNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'SITEMAP_ALREADY_CALLED';

    /**
     * @param Sitemap $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|void|null
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        if($format === 'xml')
        {
            return [
                'url' => $object->getUrlSet()->getUrls(),
            ];
        }

        return $this->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Sitemap;
    }
}
