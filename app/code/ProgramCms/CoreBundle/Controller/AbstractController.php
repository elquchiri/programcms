<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

/**
 * Class AbstractController
 * @package ProgramCms\CoreBundle\Controller\Adminhtml
 */
abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController implements ControllerInterface
{
    protected \ProgramCms\RouterBundle\Service\Response $response;
    private \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response
    )
    {
        $this->request = $request;
        $this->response = $response;
    }

    abstract public function dispatch();

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}