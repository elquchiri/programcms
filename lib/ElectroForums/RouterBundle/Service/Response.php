<?php


namespace ElectroForums\RouterBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;

class Response
{

    private ContainerInterface $container;
    private \Twig\Environment $twig;

    public function __construct(
        ContainerInterface $container,
        \Twig\Environment $twig
    )
    {
        $this->container = $container;
        $this->twig = $twig;
    }

    public function render($parameters = []): \Symfony\Component\HttpFoundation\Response
    {
        $viewModel = new \ElectroForums\ThemeBundle\Model\View();
        //$viewModel->setViewPath($routeName);

        $content = $this->twig->render('user_index_index.layout.twig');

        $response ??= new \Symfony\Component\HttpFoundation\Response();

        if (200 === $response->getStatusCode()) {
            foreach ($parameters as $v) {
                if ($v instanceof FormInterface && $v->isSubmitted() && !$v->isValid()) {
                    $response->setStatusCode(422);
                    break;
                }
            }
        }

        $response->setContent($content);

        return $response;
    }

    public function renderJson()
    {

    }
}