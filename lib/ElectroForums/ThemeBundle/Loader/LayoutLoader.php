<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Loader;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Error\LoaderError;
use Twig\Source;


class LayoutLoader implements \Twig\Loader\LoaderInterface
{
    const DEFAULT_LAYOUT_FILE = 'default.layout.twig';

    protected \Twig\Environment $environment;
    private $paths;
    private ContainerInterface $container;
    private $cache;
    private $errorCache;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    private function initLayoutPaths()
    {
        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');
        foreach ($bundles as $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            $bundleDirectory = dirname($reflectedBundle->getFileName());
            $layoutPath = $bundleDirectory . '/Resources/layout';

            if(is_dir($layoutPath)) {
                $this->paths[] = $layoutPath;
            }

            // Get All Page Layout files inside ThemeBundle to can pick page's layout
            if($reflectedBundle->getShortName() == 'ElectroForumsThemeBundle') {
                $pageLayoutPath = $bundleDirectory . '/Resources/page_layout';
                $this->paths[] = $pageLayoutPath;
            }
        }
    }

    public function getSourceContext(string $name): Source
    {
        if (null === $paths = $this->findLayout($name)) {
            return new Source('', $name, '');
        }

        $source = "{% EFLayoutStarter %}";

        foreach($paths as $path) {
            $templateContent = file_get_contents($path);
            $source .= $templateContent;
        }

        $source .= "{% endEFLayoutStarter %}";

        return new Source($source, $name, $path = '');
    }

    protected function findLayout(string $name, bool $throw = true)
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        if (isset($this->errorCache[$name])) {
            if (!$throw) {
                return null;
            }

            throw new LoaderError($this->errorCache[$name]);
        }

        try {
            $this->validateName($name);
        } catch (LoaderError $e) {
            if (!$throw) {
                return null;
            }

            throw $e;
        }

        // Parse and populate current layout paths
        $this->initLayoutPaths();

        if (!isset($this->paths) || empty($this->paths)) {
            $this->errorCache[$name] = sprintf('There are no registered paths for layout %s', $name);

            if (!$throw) {
                return null;
            }

            throw new LoaderError($this->errorCache[$name]);
        }

        foreach ($this->paths as $path) {
            if (is_file($path.'/'. self::DEFAULT_LAYOUT_FILE)) {
                if (false !== $realpath = realpath($path.'/'. self::DEFAULT_LAYOUT_FILE)) {
                    $this->cache[$name][] = $realpath;
                }else{
                    $this->cache[$name][] = $path.'/'. self::DEFAULT_LAYOUT_FILE;
                }
            }
            if (is_file($path.'/'. $name)) {
                if (false !== $realpath = realpath($path.'/'. $name)) {
                    $this->cache[$name][] = $realpath;
                }else{
                    $this->cache[$name][] = $path.'/'. $name;
                }
            }
        }

        if(isset($this->cache[$name]) && !empty($this->cache[$name])) {
            return $this->cache[$name];
        }

        $this->errorCache[$name] = sprintf('Unable to find layout "%s" (looked into: %s).', $name, implode(', ', $this->paths));

        if (!$throw) {
            return null;
        }

        throw new LoaderError($this->errorCache[$name]);
    }

    private function validateName(string $name): void
    {
        if (false !== strpos($name, "\0")) {
            throw new LoaderError('A template name cannot contain NUL bytes.');
        }
    }

    public function getCacheKey(string $name): string
    {
        return $name;
    }

    public function isFresh(string $name, int $time): bool
    {
        return true;
    }

    public function exists(string $name): bool
    {
        return true;
    }
}