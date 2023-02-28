<?php


namespace ElectroForums\RouterBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;

class Response
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($view, $parameters)
    {
        $content = $this->container->get('twig')->render($view, $parameters);
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
}