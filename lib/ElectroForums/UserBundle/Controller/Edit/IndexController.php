<?php


namespace ElectroForums\UserBundle\Controller\Edit;


class IndexController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/dashboard.html.twig', [

        ]);
    }
}