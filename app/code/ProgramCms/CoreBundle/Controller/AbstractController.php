<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\Response;

/**
 * Class AbstractController
 * @package ProgramCms\CoreBundle\Controller
 */
abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController implements ControllerInterface
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * AbstractController constructor.
     * @param Context $context
     */
    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context
    )
    {
        $this->request = $context->getRequest();
        $this->response = $context->getResponse();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    abstract public function dispatch(): mixed;
}