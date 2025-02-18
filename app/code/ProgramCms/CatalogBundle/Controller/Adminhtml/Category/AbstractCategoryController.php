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
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UiBundle\Component\Form\Element\Hidden;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use Exception;

/**
 * Class AbstractCategoryController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
abstract class AbstractCategoryController extends AdminController
{
    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * AbstractCategoryController constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
    )
    {
        $this->websiteManager = $context->getWebsiteManager();
        parent::__construct($context);
    }

    /**
     * @throws Exception
     */
    protected function prepareLayout(Page $pageResult)
    {
        $layout = $pageResult->getLayout();
        $request = $this->getRequest();
        $formBlock = $layout->getBlock('category_form');
        $hiddenWebsiteViewScope = $layout->createBlock(Hidden::class, 'website_view', [
            'value' => $request->getParam('website_view')
        ]);
        $formBlock->setChild('website_view', $hiddenWebsiteViewScope);
    }
}