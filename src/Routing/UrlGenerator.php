<?php


namespace Christiana\RssBundle\Routing;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlGenerator
{
    /**
     * @var array
     */
    private array $routes = [];

    public function __construct(
        private UrlGeneratorInterface $generator
    )
    {
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return UrlGenerator
     */
    public function setRoutes(array $routes): UrlGenerator
    {
        $this->routes = $routes;
        return $this;
    }

    public function getChannelRoute(string $channelName)
    {
        $baseUrl = $this->generator->getContext()->getBaseUrl();
        $route = $baseUrl.'nekek';
    }
}
