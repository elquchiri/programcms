<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\RouterBundle\Service;


class Request
{

    protected \Symfony\Component\HttpFoundation\RequestStack $requestStack;

    public function __construct(
        \Symfony\Component\HttpFoundation\RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
    }

    public function getParam($param)
    {
        return $this->getParameters()[$param] ?? '';
    }

    public function getParameters(): array
    {
        $parameters = [];

        $request = $this->getCurrentRequest();
        $requestParams = explode('/', $request->get('parameters'));

        for ($i=0; $i<count($requestParams); $i++) {
            if(!isset($requestParams[$i+1])) {
                break;
            }

            $parameters[$requestParams[$i]] = $requestParams[$i+1];
        }

        return $parameters ?? [];
    }

    public function getCurrentRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function getCurrentAreaCode()
    {
        return str_starts_with($this->getCurrentRequest()->get('_route'), 'adminhtml_') ? 'adminhtml' : 'frontend';
    }

    public function getCurrentRouteName(): string
    {
        $layoutNameElements = explode("_", $this->getCurrentRequest()->get('_route'));
        return $layoutNameElements[1] . '_' . $layoutNameElements[2] . '_' . $layoutNameElements[3] . '.layout.twig';
    }
}