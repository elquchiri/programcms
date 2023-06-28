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

    public function getBlock(string $name);

    public function getChildBlock(string $parentName, string $alias);

    public function setChild(string $parentName, string $elementName, string $alias);

    public function getChildNames(string $parentName);

    public function getChildBlocks(string $parentName);

    public function getParentName(string $childName);

    public function createBlock($type, string $name = '', array $arguments = []);
}