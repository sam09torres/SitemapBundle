<?php


namespace Christiana\SitemapBundle\Serialization\Encoder;


class XmlEncoder extends \Symfony\Component\Serializer\Encoder\XmlEncoder
{
    const FORMAT = 'xml';

    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     * @return false|string
     */
    public function encode($data, string $format, array $context = [])
    {

        return parent::encode($data, self::FORMAT, $context);
    }

    /**
     * @inheritDoc
     */
    public function supportsEncoding(string $format)
    {
        return $format === self::FORMAT;
    }
}
