<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Address;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UiBundle\Component\Form\Element\Hidden;

/**
 * Class NewController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Address
 */
class NewController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * NewController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return mixed|object|null
     * @throws \ReflectionException
     */
    public function execute()
    {
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $layout = $pageResult->getLayout();
        $userId = $this->getRequest()->getParam('user');
        $addressForm = $layout->getBlock('user_address_form');
        $hiddenUserInput = $layout->createBlock(Hidden::class, 'user_id', [
            'value' => $userId
        ]);
        $addressForm->setChild('user_id', $hiddenUserInput);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("New Address")
        );
        return $pageResult;
    }
}