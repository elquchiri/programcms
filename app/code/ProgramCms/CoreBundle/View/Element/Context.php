<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\RouterBundle\Service\Request;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\View\Element
 */
class Context
{
    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * Context constructor.
     * @param DirectoryList $directoryList
     * @param Request $request
     */
    public function __construct(
        DirectoryList $directoryList,
        Request $request
    )
    {
        $this->directoryList = $directoryList;
        $this->request = $request;
    }

    /**
     * @return DirectoryList
     */
    public function getDirectoryList(): DirectoryList
    {
        return $this->directoryList;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}