<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Controller\Edit;


class PasswordController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/password.html.twig', [

        ]);
    }
}