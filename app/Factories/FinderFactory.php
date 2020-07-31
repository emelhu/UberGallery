<?php

namespace App\Factories;

use App\Config;
use App\Exceptions\InvalidConfiguration;
use Closure;
use DI\Container;
use Symfony\Component\Finder\Finder;

class FinderFactory
{
    protected Container $container;
    protected Config $config;

    /** Create a new FinderFactory object. */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    /** Initialize and return the Finder component. */
    public function __invoke(): Finder
    {
        $finder = Finder::create()->followLinks();
        $finder->ignoreVCS($this->config->get('hide_vcs_files'));

        // $sortOrder = $this->config->get('sort_order');
        // if ($sortOrder instanceof Closure) {
        //     $finder->sort($sortOrder);
        // } else {
        //     if (! array_key_exists($sortOrder, $this->config->get('sort_methods'))) {
        //         throw InvalidConfiguration::fromConfig('sort_order', $sortOrder);
        //     }

        //     $this->container->call($this->config->get('sort_methods')[$sortOrder], [$finder]);
        // }

        if ($this->config->get('reverse_sort')) {
            $finder->reverseSorting();
        }

        return $finder;
    }
}
