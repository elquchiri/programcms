<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use Twig\Environment;

/**
 * Class IndexController
 * @package ProgramCms\CmsBundle\Controller\Index
 */
class IndexController extends Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var Environment
     */
    protected Environment $environment;

    /**
     * IndexController constructor.
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
     * Get home page content from dynamic pages
     * Fallback to the default layout
     * @return object|null
     */
    public function execute()
    {
        // Prepare Home CMS Page by Id & send content
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);


        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Home Page")
        );
        return $pageResult;
    }
}