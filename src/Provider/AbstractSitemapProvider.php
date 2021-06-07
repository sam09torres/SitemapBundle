<?php


namespace Christiana\SitemapBundle\Provider;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractSitemapProvider implements SitemapProviderInterface
{
    /**
     * @var string[]
     */
    protected array $locales = [];

    /**
     * @var UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * @var array
     */
    private array $mapping;


    /**
     * @return UrlGeneratorInterface
     */
    public function getUrlGenerator(): UrlGeneratorInterface
    {
        return $this->urlGenerator;
    }

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @return AbstractSitemapProvider
     */
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator): AbstractSitemapProvider
    {
        $this->urlGenerator = $urlGenerator;
        return $this;
    }

    /**
     * @param array $mapping
     * @return AbstractSitemapProvider
     */
    public function setMapping(array $mapping): AbstractSitemapProvider
    {
        $this->mapping = $mapping;
        return $this;
    }

    /**
     * @param string[] $locales
     * @return AbstractSitemapProvider
     */
    public function setLocales(array $locales): AbstractSitemapProvider
    {
        $this->locales = $locales;
        return $this;
    }

}
