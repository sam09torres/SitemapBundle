<?php


namespace Christiana\SitemapBundle\Serialization\Encoder;


use Symfony\Component\Serializer\Encoder\EncoderInterface;

class TextEncoder implements EncoderInterface
{
    const FORMAT = 'txt';

    /**
     * @inheritDoc
     */
    public function encode($data, string $format, array $context = [])
    {
        $lines = '';

        foreach ($data as $line)
        {
            $lines .= $line.\PHP_EOL;
        }

        return $lines;
    }

    /**
     * @inheritDoc
     */
    public function supportsEncoding(string $format)
    {
        return $format === self::FORMAT;
    }
}
