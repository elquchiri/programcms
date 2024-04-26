<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Theme;

/**
 * Class AbstractTheme
 * @package ProgramCms\CoreBundle\Theme
 */
abstract class AbstractTheme implements ThemeInterface
{
    /**
     * Theme Path
     * @var string
     */
    protected string $path;

    /**
     * Theme Name
     * @var string
     */
    protected string $name;

    /**
     * Theme Class Namespace
     * @var string
     */
    protected string $namespace;

    /**
     * Theme Parent
     * @var string
     */
    protected string $parent;

    /**
     * Get Theme Path
     * @return string
     */
    public function getPath(): string
    {
        if (!isset($this->path) || $this->path === null) {
            $reflected = new \ReflectionObject($this);
            $this->path = \dirname($reflected->getFileName());
        }

        return $this->path;
    }

    /**
     * Get Theme Name
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? '';
    }

    /**
     * Default Parent Theme
     * If no parent theme defined this one will be used.
     * @return string
     */
    public function getParent(): string
    {
        return $this->parent;
    }

    /**
     * Get Theme Namespace
     * @return string
     */
    public function getNamespace(): string
    {
        if (!isset($this->namespace)) {
            $this->parseClassName();
        }

        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return self::DEFAULT_AREA;
    }

    /**
     * @return string
     */
    public function getShortPath(): string
    {
        return strtolower(str_replace('\\', '/', $this->getNamespace()));
    }

    /**
     * Parse Theme Class Name
     */
    private function parseClassName()
    {
        $pos = strrpos(static::class, '\\');
        $this->namespace = false === $pos ? '' : substr(static::class, 0, $pos);
        $this->name ??= false === $pos ? static::class : substr(static::class, $pos + 1);
    }
}