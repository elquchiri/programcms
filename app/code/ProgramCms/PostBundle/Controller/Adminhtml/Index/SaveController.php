<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Adminhtml\Index;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ReflectionException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SaveController
 * @package ProgramCms\PostBundle\Controller\Adminhtml\Index
 */
class SaveController extends AdminController
{
    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;
    protected CategoryRepository $categoryRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectSerializer $objectSerializer
     * @param Url $url
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        ObjectSerializer $objectSerializer,
        Url $url,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->objectSerializer = $objectSerializer;
        $this->url = $url;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->isMethod('POST')) {
            $postId = $this->getRequest()->getParam('entity_id');

            /** @var PostEntity $post */
            if($postId) {
                $post = $this->postRepository->getById($postId);
            }else{
                $post = new PostEntity();
                $post->setCreatedAt();
            }

            // Populate Category Entity
            $postData = $request->request->all();
            $files = $request->files->all();
            $formData = array_merge($postData, $files);
            unset($postData);
            unset($files);

            if(isset($formData['entity_id']) && empty($formData['entity_id'])) {
                unset($formData['entity_id']);
            }

            if(isset($formData['website_view']) && !empty($formData['website_view'])) {
                // Set Current Website View
                $this->websiteManager->setCurrentWebsiteView($formData['website_view']);
            }

            // Transform form data to user object
            $this->objectSerializer->arrayToObject($post, $formData);

            // Add data for eav processing
            $post->addData($formData);

            // Editor fields
            $editorJson = $this->getRequest()->getParam('data');
            $postTitle = $this->getRequest()->getParam('title');
            $postHtml = $this->getRequest()->getParam('html');
            $postCss = $this->getRequest()->getParam('css');
            $post
                ->setPostName($postTitle)
                ->setPostContent($editorJson)
                ->setPostHtml($postHtml)
                ->setPostCss($postCss)
                ->setUpdatedAt();

            if(isset($formData['post_categories']) && !empty($formData['post_categories'])) {
                $categories = explode(',', $formData['post_categories']);
                foreach($categories as $categoryId) {
                    /** @var CategoryEntity $category */
                    $category = $this->categoryRepository->getById($categoryId);
                    $post->addCategory($category);
                }
            }

            // Save Category
            $this->postRepository->save($post);
            $this->addFlash('success', $this->trans('Post successfully saved.'));
            return $this->json([
                'success' => true,
                'redirect_url' => $this->url->getUrlByRouteName('post_index_index')
            ]);
        }

        return $this->json([
            'success' => false,
            'message' => $this->trans('Error Loading the post')
        ]);
    }
}