<?php


namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\SystemWebsite;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    public function execute()
    {
        return $this->getResponse()->render();
    }
}