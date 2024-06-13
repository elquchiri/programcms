<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use ReflectionException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;

/**
 * Class SaveController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
class SaveController extends AdminController
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param CategoryRepository $categoryRepository
     * @param Url $url
     * @param ObjectSerializer $objectSerializer
     */
    public function __construct(
        Context $context,
        CategoryRepository $categoryRepository,
        Url $url,
        ObjectSerializer $objectSerializer
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->categoryRepository = $categoryRepository;
        $this->objectSerializer = $objectSerializer;
    }

    /**
     * @return RedirectResponse
     * @throws ReflectionException
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->isMethod('POST')) {
            $categoryId = $this->getRequest()->getParam('entity_id');

            /** @var CategoryEntity $category */
            if($categoryId) {
                $category = $this->categoryRepository->getById($categoryId);
            }else{
                $category = new CategoryEntity();
                $category->setCreatedAt();
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
            $this->objectSerializer->arrayToObject($category, $formData);

            $category->setUpdatedAt();

            // Add data for eav processing
            $category->addData($formData);

            // Save Category
            $this->categoryRepository->save($category);
            $this->addFlash('success', $this->trans('Category successfully saved.'));
            return $this->redirect($this->url->getUrlByRouteName('catalog_category_edit', $this->redirectParams($request, $category->getEntityId())));
        }
        return $this->redirect($this->url->getUrlByRouteName('catalog_category_index'));
    }

    /**
     * @param $request
     * @param $id
     * @return array
     */
    private function redirectParams($request, $id)
    {
        // Scope Switcher Redirection
        $redirectParams = ['id' => $id];
        $websiteViewSwitcher = $request->get('website_view');
        if(!empty($websiteViewSwitcher)) {
            $redirectParams['website_view'] = $websiteViewSwitcher;
        }
        return $redirectParams;
    }
}