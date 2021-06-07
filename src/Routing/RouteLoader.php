<?php


namespace Christiana\SitemapBundle\Routing;


use Christiana\SitemapBundle\Controller\SitemapController;
use Christiana\SitemapBundle\Generator\Generator;
use Christiana\SitemapBundle\Generator\GeneratorInterface;
use Christiana\SitemapBundle\SitemapService;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader extends Loader
{
    private $loaded = false;

    public function __construct(
        private Generator $generator,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function load($resource, string $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();
        $formats = $this->generator->getFormats();
        $defaultFormat = $this->generator->getDefaultFormat();

        if($this->generator->isEnableIndex()) {
            //INDEX

            $path = $this->generator->getIndexPath().'.{_format}';
            $route = new Route($path, [
                '_controller' => SitemapController::class . '::index',
            ], [], [], null, [], ['GET']);

            $routes->add('christiana.sitemap_index', $route);

            //SITEMAPS
            foreach($this->generator->getSitemaps() as $name => $sitemap)
            {
                $sitemap['name'] = $name;
                $path = $sitemap['route_path'].'.{_format}';

                $route = new Route($path, [
                    '_controller' => SitemapController::class.'::sitemap',
                    '_sitemap' => $sitemap,
                ],[], [],null,[],['GET']);

                $routeName = 'christiana.sitemap.'.$name;

                $routes->add($routeName, $route);
            }

        }else{

            $path = $this->generator->getIndexPath().'.{_format}';

            $route = new Route($path, [
                '_controller' => SitemapController::class.'::index',
            ],[], [],null,[],['GET']);

            $routes->add('christiana.sitemap', $route);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * @inheritDoc
     */
    public function supports($resource, string $type = null)
    {
        return $type === 'sitemap';
    }
}
