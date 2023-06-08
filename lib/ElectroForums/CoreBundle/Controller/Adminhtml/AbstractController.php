<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CoreBundle\Controller\Adminhtml;

/**
 * Class AbstractController
 * @package ElectroForums\CoreBundle\Controller\Adminhtml
 */
abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected \ElectroForums\RouterBundle\Service\Response $response;
    private \ElectroForums\RouterBundle\Service\Request $request;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\RouterBundle\Service\Response $response
    )
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Overrides method in each Controller
     * @return mixed
     */
    abstract public function execute();

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}