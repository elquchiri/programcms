<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;


class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    private $categoryRepository;
    private $toolbar;

    public function __construct(
        \ProgramCms\CategoryBundle\Repository\CategoryRepository $categoryRepository,
        \ProgramCms\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->toolbar = $toolbar;
    }

    public function execute()
    {
        $this->toolbar->addButton("Save", "", "primary");

        return $this->render('@ProgramCmsCategory/adminhtml/category_tree.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'includeWebsiteSwitcher' => true
        ]);
    }
}