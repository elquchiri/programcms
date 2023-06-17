<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Edit;


class InformationController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/edit.html.twig', [

        ]);
    }
}