<?php


namespace ElectroForums\UserBundle\Controller\Edit;


class InformationController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/edit.html.twig', [

        ]);
    }
}