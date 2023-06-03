<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CategoryBundle\Controller\Adminhtml\Index;


class CreateController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private $categoryRepository;
    private $toolbar;

    public function __construct(
        \ElectroForums\CategoryBundle\Repository\CategoryRepository $categoryRepository,
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->toolbar = $toolbar;
    }

    public function execute()
    {
        return $this->render('@ElectroForumsCategory/adminhtml/category_tree.html.twig', [

        ]);
    }
}