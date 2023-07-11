<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml;

/**
 * Class AbstractConfigController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml
 */
abstract class AbstractConfigController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     */
    protected function loadConfigurations()
    {
        return $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
    }
}