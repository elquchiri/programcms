<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;

/**
 * Class CreateWithParentController
 * @package ProgramCms\CategoryBundle\Controller\Adminhtml\Index
 */
class CreateWithParentController extends \ProgramCms\CoreBundle\Controller\Controller
{

    private $categoryRepository;

    public function __construct(
        \ProgramCms\CategoryBundle\Repository\CategoryRepository $categoryRepository,
    )
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute()
    {

    }
}