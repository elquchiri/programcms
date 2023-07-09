<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

/**
 * Interface LayoutInterface
 * @package ProgramCms\CoreBundle\View
 */
interface LayoutInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getBlock(string $name);

    /**
     * @param string $parentName
     * @param string $alias
     * @return mixed
     */
    public function getChildBlock(string $parentName, string $alias);

    /**
     * @param string $parentName
     * @param string $elementName
     * @param string $alias
     * @return mixed
     */
    public function setChild(string $parentName, string $elementName);

    /**
     * @param string $parentName
     * @return mixed
     */
    public function getChildNames(string $parentName);

    /**
     * @param string $parentName
     * @return mixed
     */
    public function getChildBlocks(string $parentName);

    /**
     * @param string $childName
     * @return mixed
     */
    public function getParentName(string $childName);

    /**
     * @param $type
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function createBlock($type, string $name = '', array $arguments = []);
}