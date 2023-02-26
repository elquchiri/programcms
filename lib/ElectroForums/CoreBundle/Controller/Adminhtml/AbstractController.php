<?php


namespace ElectroForums\CoreBundle\Controller\Adminhtml;


use Symfony\Component\HttpFoundation\Request;
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

    abstract public function execute();

    public function getRequest()
    {
        return $this->request;
    }

    protected function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        $viewModel = new \ElectroForums\ThemeBundle\Model\View();
        $viewModel->setViewPath($view);

        return parent::render(
            $viewModel->getViewPath(),
            $parameters,
            $response
        );
    }
}