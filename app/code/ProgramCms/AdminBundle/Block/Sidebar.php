<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block;

use ProgramCms\AdminBundle\Model\MenuConfigSerializer;
use ReflectionException;

/**
 * Class Sidebar
 * @package ProgramCms\AdminBundle\Block
 */
class Sidebar extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var MenuConfigSerializer
     */
    protected MenuConfigSerializer $menuConfigSerializer;

    /**
     * @throws ReflectionException
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        MenuConfigSerializer $menuConfigSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->menuConfigSerializer = $menuConfigSerializer;
        $this->_initConfigSerializer();
    }

    /**
     * @throws ReflectionException
     */
    private function _initConfigSerializer()
    {
        $this->menuConfigSerializer->parseMenuConfig();
    }

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return $this->menuConfigSerializer->getMenu();
    }
}