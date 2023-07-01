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
    /**
     * @var \ProgramCms\RouterBundle\Service\Response
     */
    protected \ProgramCms\RouterBundle\Service\Response $response;
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    private \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response
    )
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    abstract public function dispatch(): mixed;

    /**
     * @return \ProgramCms\RouterBundle\Service\Request
     */
    public function getRequest(): \ProgramCms\RouterBundle\Service\Request
    {
        return $this->request;
    }

    /**
     * @return \ProgramCms\RouterBundle\Service\Response
     */
    public function getResponse(): \ProgramCms\RouterBundle\Service\Response
    {
        return $this->response;
    }
}