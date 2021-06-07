<?php

namespace Christiana\SitemapBundle\Command;

use Christiana\SitemapBundle\SitemapService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SiteMapGeneratorCommand extends Command
{
    protected static $defaultName = 'sitemap:generate';
    protected static $defaultDescription = 'Generate sitemap';

    private $routes = [];

    public function __construct(
        private SitemapService $siteMapService,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->siteMapService->generate(true);
        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }

        $io->success(sprintf("Sitemap generated : %s", $this->exportPath));

        return Command::SUCCESS;
    }
}
