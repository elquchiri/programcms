<?php


namespace ElectroForums\UserBundle\Controller\Edit;


class PasswordController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/password.html.twig', [

        ]);
    }
}