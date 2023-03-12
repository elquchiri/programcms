<?php


namespace ElectroForums\CoreBundle\Controller\Adminhtml;


use Symfony\Component\HttpFoundation\Response;


abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    private \ElectroForums\RouterBundle\Service\Request $request;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request
    )
    {
        $this->request = $request;
    }

    /**
     * Overrides method in each Controller
     * @return mixed
     */
    abstract public function execute();

    public function getRequest()
    {
        return $this->request;
    }
}