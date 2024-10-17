<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\User;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\User
 */
class IndexController extends AdminController
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
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->translator->trans("Admin Users")
        );
        return $pageResult;
    }
}