<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Adminhtml\Index;

use Exception;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UiBundle\Component\Form\Element\Hidden;
use ReflectionException;

/**
 * Class EditController
 * @package ProgramCms\PostBundle\Controller\Adminhtml\Index
 */
class EditController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PostRepository $postRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
    }

    /**
     * @return object
     * @throws ReflectionException
     */
    public function execute(): object
    {
        $postId = $this->getRequest()->getParam('id');
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        if($postId) {
            $post = $this->postRepository->getById($postId);
            $pageResult->getConfig()->getTitle()->set(
                $this->trans($post->getPostName())
            );
        }

        $this->prepareLayout($pageResult);

        return $pageResult;
    }

    /**
     * @param Page $pageResult
     * @throws Exception
     */
    protected function prepareLayout(Page $pageResult)
    {
        $layout = $pageResult->getLayout();
        $request = $this->getRequest();
        $formBlock = $layout->getBlock('post_form');
        $hiddenWebsiteViewScope = $layout->createBlock(Hidden::class, 'website_view', [
            'value' => $request->getParam('website_view')
        ]);
        $formBlock->setChild('website_view', $hiddenWebsiteViewScope);
    }
}