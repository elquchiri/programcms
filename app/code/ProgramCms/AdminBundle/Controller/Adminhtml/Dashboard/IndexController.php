<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\Dashboard;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\Dashboard
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        TranslatorInterface $translator
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->translator = $translator;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->translator->trans("Dashboard")
        );
        return $pageResult;
    }
}