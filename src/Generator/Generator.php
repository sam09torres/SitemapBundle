<?php


namespace Christiana\SitemapBundle\Generator;


use Christiana\SitemapBundle\Builder\BuilderInterface;
use Christiana\SitemapBundle\Model\Sitemap;
use Christiana\SitemapBundle\Model\SitemapIndex;
use Christiana\SitemapBundle\Model\UrlSet;
use Christiana\SitemapBundle\Provider\AbstractSitemapProvider;
use Christiana\SitemapBundle\Provider\SitemapProviderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Generator implements GeneratorInterface
{
    /**
     * @var array<string,SitemapProviderInterface>
     */
    private array $providers = [];

    /**
     * @var string[]
     */
    private array $locales = [];

    /**
     * @var Sitemap[]
     */
    private array $sitemaps = [];

    /**
     * @var bool
     */
    private bool $enableIndex;

    /**
     * @var string
     */
    private string $indexPath;

    /**
     * @var string
     */
    private string $defaultFormat;

    /**
     * @var string[]
     */
    private array $formats;


    public function __construct(
        private UrlGeneratorInterface $generator,
        private BuilderInterface $builder,
    ) {
    }

    /**
     * @return SitemapProviderInterface|iterable
     */
    public function getProviders(): iterable|SitemapProviderInterface
    {
        return $this->providers;
    }

    /**
     * @param SitemapProviderInterface|iterable $providers
     * @return self
     */
    public function setProviders(iterable|SitemapProviderInterface $providers): self
    {
        if($providers instanceof \Traversable)
            $providers = iterator_to_array($providers);

        $this->providers = [];

        foreach ($providers as $provider)
        {
            $this->addProvider($provider);
        }

        return $this;
    }

    /**
     * @param string $providerClass
     * @return bool
     */
    public function hasProvider(string $providerClass): bool
    {
        return array_key_exists($providerClass, $this->providers);
    }

    public function addProvider(SitemapProviderInterface $provider): self
    {
        $this->providers[$provider::class] = $provider;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param string[] $locales
     * @return self
     */
    public function setLocales(array $locales): self
    {
        $this->locales = $locales;
        return $this;
    }

    /**
     * @return Sitemap[]
     */
    public function getSitemaps(): array
    {
        return $this->sitemaps;
    }

    /**
     * @param Sitemap[] $sitemaps
     * @return self
     */
    public function setSitemaps(array $sitemaps): self
    {
        $this->sitemaps = $sitemaps;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableIndex(): bool
    {
        return $this->enableIndex;
    }

    /**
     * @param bool $enableIndex
     * @return self
     */
    public function setEnableIndex(bool $enableIndex): self
    {
        $this->enableIndex = $enableIndex;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndexPath(): string
    {
        return $this->indexPath;
    }

    /**
     * @param string $indexPath
     * @return self
     */
    public function setIndexPath(string $indexPath): self
    {
        $this->indexPath = $indexPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultFormat(): string
    {
        return $this->defaultFormat;
    }

    /**
     * @param string $defaultFormat
     * @return self
     */
    public function setDefaultFormat(string $defaultFormat): self
    {
        $this->defaultFormat = $defaultFormat;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFormats(): array
    {
        return $this->formats;
    }

    /**
     * @param string[] $formats
     * @return Generator
     */
    public function setFormats(array $formats): Generator
    {
        $this->formats = $formats;
        return $this;
    }

    public function generateIndex(?string $format = null): string
    {
        if(!$format)
            $format = $this->getDefaultFormat();

        $index = new SitemapIndex();

        foreach ($this->sitemaps as $sm)
        {
            $providerClass = $sm['provider'];
            if(!$this->hasProvider($providerClass))
                continue;

            $provider = $this->providers[$providerClass];

            if($provider instanceof AbstractSitemapProvider)
            {
                $provider->setLocales($this->locales);
                $provider->setUrlGenerator($this->generator);
            }

            $sitemap = new Sitemap();
            $set = new UrlSet();

            $provider->build($set);

            $context = $this->generator->getContext();
            $path = $context->getScheme().'://'.$context->getHost().$sm['route_path'];
            $sitemap->setPath($path);
            $sitemap->setUrlSet($set);

            $index->addSitemap($sitemap);
        }

        return $this->builder->buildIndex($index, $format, !$this->isEnableIndex());

    }

    public function generateSitemap(string $sitemapName, ?string $format = null): string
    {
        if(!$format)
            $format = $this->getDefaultFormat();

        $sm = $this->sitemaps[$sitemapName];

        $providerClass = $sm['provider'];
        if(!$this->hasProvider($providerClass))
            throw new \Exception(sprintf("Provider '%s' doesn't exist for sitemap '%s'",$providerClass, $sitemapName));

        $provider = $this->providers[$providerClass];

        if($provider instanceof AbstractSitemapProvider)
        {
            $provider->setLocales($this->locales);
            $provider->setUrlGenerator($this->generator);
        }

        $sitemap = new Sitemap();
        $set = new UrlSet();
        $provider->build($set);

        $sitemap->setPath($sm['route_path']);
        $sitemap->setUrlSet($set);

        return $this->builder->buildSitemap($sitemap, $format);
    }
}
