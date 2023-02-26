<?php


namespace ElectroForums\UserBundle\Controller\Test;


class TestUserController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ElectroForums\ConfigBundle\Model\Config $config;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\ConfigBundle\Model\Config $config
    )
    {
        $this->config = $config;
        parent::__construct($request);
    }

    public function execute()
    {
        $city = $this->getParam('city');
        echo 'Country = ' . $this->getParam('country');
        exit('ok = ' . $city);
    }
}