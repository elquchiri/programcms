<?php


namespace ElectroForums\RouterBundle\Service;


class Request
{

    private \Symfony\Component\DependencyInjection\Container $container;

    public function __construct(
        \Symfony\Component\DependencyInjection\Container $container
    )
    {
        $this->container = $container;
    }

    public function getParam($param)
    {
        $parameters = [];

        $request = $this->container->get('request_stack')->getCurrentRequest();
        $requestParams = explode('/', $request->get('parameters'));

        for ($i=0; $i<count($requestParams); $i++) {
            if(!isset($requestParams[$i+1])) {
                break;
            }

            $parameters[$requestParams[$i]] = $requestParams[$i+1];
        }

        return $parameters[$param] ?? '';
    }

    public function getCurrentRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}