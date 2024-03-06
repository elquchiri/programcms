<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Config;

use Countable;
use Iterator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileIterator
 * @package ProgramCms\CoreBundle\Config
 */
class FileIterator implements Iterator, Countable
{
    /**
     * @var array
     */
    protected array $paths = [];

    /**
     * @var int
     */
    protected int $position;

    /**
     * Constructor
     *
     * @param Filesystem $readFactory
     * @param array $paths
     */
    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
        $this->position = 0;
    }

    /**
     * Rewind
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        reset($this->paths);
    }

    /**
     * Current
     *
     * @return string
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return file_get_contents($this->key());
    }

    /**
     * Key
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return current($this->paths);
    }

    /**
     * Next
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        next($this->paths);
    }

    /**
     * Valid
     *
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return (bool) $this->key();
    }

    /**
     * Convert to an array
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function toArray()
    {
        $result = [];
        foreach ($this as $item) {
            $result[$this->key()] = $item;
        }
        return $result;
    }

    /**
     * Count
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->paths);
    }
}
