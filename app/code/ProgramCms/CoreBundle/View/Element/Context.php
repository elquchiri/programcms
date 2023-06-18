<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\View\Element
 */
class Context
{

    protected \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    protected \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList,
        \ProgramCms\RouterBundle\Service\Request $request
    )
    {
        $this->directoryList = $directoryList;
        $this->request = $request;
    }

    public function getDirectoryList()
    {
        return $this->directoryList;
    }

    public function getRequest(): \ProgramCms\RouterBundle\Service\Request
    {
        return $this->request;
    }
}