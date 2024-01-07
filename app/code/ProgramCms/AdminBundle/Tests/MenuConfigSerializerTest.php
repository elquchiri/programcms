<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class MenuConfigSerializerTest
 * @package ProgramCms\AdminBundle\Tests
 */
class MenuConfigSerializerTest extends KernelTestCase
{

    public function testEmptyGetUrl()
    {
        self::bootKernel();
        $container = static::getContainer();
        $menuConfigSerializer = $container->get('ProgramCms\AdminBundle\Model\MenuConfigSerializer');

        $action = "";
        $url = $menuConfigSerializer->_getUrl($action);

        $this->assertEquals("", $url);
    }

    public function testActionGetUrl()
    {
        self::bootKernel();
        $container = static::getContainer();
        $menuConfigSerializer = $container->get('ProgramCms\AdminBundle\Model\MenuConfigSerializer');

        $action = "forum_forum_forum";
        $url = $menuConfigSerializer->_getUrl($action);

        $this->assertEquals("http://localhost/forum/forum/forum", $url);
    }
}