<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;

use ProgramCms\CategoryBundle\Repository\CategoryRepository;

/**
 * Class CreateController
 * @package ProgramCms\CategoryBundle\Controller\Adminhtml\Index
 */
class CreateController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($request, $response);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed|void
     */
    public function execute()
    {

    }
}