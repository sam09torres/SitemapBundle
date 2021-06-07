<?php

namespace Christiana\SitemapBundle\Controller;

use Christiana\SitemapBundle\Generator\Generator;
use Christiana\SitemapBundle\SitemapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends AbstractController
{

    public function __construct(
        private Generator $generator
    )
    {
    }

    private function send(string $data, string $mimeType)
    {
        $response = new Response($data);
        $response->headers->set('Content-Type', $mimeType);
        return $response;
    }

    public function index(Request $request)
    {
        $format = $request->getRequestFormat();
        $formats = $this->generator->getFormats();
        if(!array_key_exists($format, $formats))
            throw new \Exception(sprintf("Missing mime type in 'formats' for the extension '%s'. Available formats : %s",$format, join(', ', array_keys($formats))));

        $index = $this->generator->generateIndex($format);
        $mimeType = $formats[$format];

        return $this->send($index,$mimeType);

    }

    public function sitemap(Request $request)
    {
        $format = $request->getRequestFormat();
        $formats = $this->generator->getFormats();

        if(!array_key_exists($format, $formats))
            throw new \Exception(sprintf("Missing mime type in 'formats' for the extension '%s'. Available formats : %s",$format, join(', ', array_keys($formats))));

        $sitemapName = $request->attributes->get('_sitemap')['name'];

        $sitemap = $this->generator->generateSitemap($sitemapName,$format);
        $mimeType = $formats[$format];

        return $this->send($sitemap,$mimeType);

    }
}
