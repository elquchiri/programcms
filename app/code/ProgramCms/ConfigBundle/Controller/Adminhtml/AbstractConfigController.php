<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractConfigController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml
 */
abstract class AbstractConfigController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($request, $response);
        $this->objectManager = $objectManager;
    }

    protected function loadConfigurations()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        return $pageResult;
    }
}