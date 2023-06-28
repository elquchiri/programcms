<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Edit;


class PasswordController extends \ProgramCms\CoreBundle\Controller\Controller
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/password.html.twig', [

        ]);
    }
}