<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UiBundle\Component\Form\Field;
use ReflectionException;

/**
 * Class AddController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
class AddController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * AddController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $parent = $this->getRequest()->getParam('parent');
        if(!$parent) {
            // Redirect to default category
        }

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans('New Category')
        );

        $layout = $pageResult->getLayout();
        /** @var Field $parentFieldBlock */
        $parentFieldBlock = $layout->getBlock('parent');
        $field = $parentFieldBlock->getChildBlock($parentFieldBlock->getName() . '_field');
        $field->setValue($parent);

        return $pageResult;
    }
}