<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class Request
 * @package ProgramCms\RouterBundle\Service
 */
class Request
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected \Symfony\Component\HttpFoundation\Request $request;

    /**
     * @var RouterInterface
     */
    protected RouterInterface $router;

    /**
     * @var RequestStack
     */
    protected RequestStack $requestStack;

    /**
     * Request constructor.
     * @param RouterInterface $router
     * @param RequestStack $requestStack
     */
    public function __construct(
        RouterInterface $router,
        RequestStack $requestStack
    )
    {
        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * Get param from request query or from request data
     * @param $param
     * @param string $defaultValue
     * @return mixed
     */
    public function getParam($param, string $defaultValue = ''): mixed
    {
        if(isset($this->getParameters()[$param])) {
            return $this->getParameters()[$param];
        }else if($this->getCurrentRequest()->get($param)) {
            return $this->getCurrentRequest()->get($param);
        }
        return $defaultValue;
    }

    /**
     * Checks if param exists in the request
     * @param $param
     * @return bool
     */
    public function hasParam($param): bool
    {
        return !empty($this->getParam($param)) && !is_null($this->getParam($param));
    }

    /**
     * Set Request Parameter
     * @param $param
     * @param $value
     */
    public function setParam($param, $value)
    {
        $this->getCurrentRequest()->request->set($param, $value);
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        $parameters = $this->getCurrentRequest()->query->all();
        $request = $this->getCurrentRequest();
        $requestParams = $request->get('parameters');
        if(is_array($requestParams)) {
            return $requestParams;
        }

        $requestParams = explode('/', $request->get('parameters'));
        for ($i = 0; $i < count($requestParams) - 1; $i += 2) {
            $key = $requestParams[$i];
            $value = $requestParams[$i + 1];
            $parameters[$key] = $value;
        }

        return $parameters ?? [];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request|null
     */
    public function getCurrentRequest(): ?\Symfony\Component\HttpFoundation\Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Get Request Path
     * For a request to http://example.com/routeName/folder/controller
     * the path info is "/routeName/folder/controller"
     *
     * @return string
     */
    public function getPathInfo(): string
    {
        return $this->request->getPathInfo();
    }

    /**
     * @return string
     */
    public function getCurrentAreaCode(): string
    {
        return str_starts_with($this->getFullRouteName(), 'adminhtml_') ? 'adminhtml' : 'frontend';
    }

    /**
     * @return string
     */
    public function getCurrentRouteName(): string
    {
        $layoutNameElements = explode("_", $this->getFullRouteName());
        if(isset($layoutNameElements[0]) && in_array($layoutNameElements[0], ['frontend', 'adminhtml'])) {
            array_shift($layoutNameElements);
            return implode("_", $layoutNameElements);
        }
        return $this->getFullRouteName();
    }

    /**
     * Full route name including areaCode
     * [frontend, adminhtml]_routeName_folder_controller
     * @return string
     */
    public function getFullRouteName(): string
    {
        return $this->getCurrentRequest()->attributes->get('_route');
    }

    /**
     * Extract route area from full route name
     * @return string
     */
    public function getFrontName(): string
    {
        $fullRouteName = explode("_", $this->getFullRouteName());
        if(count($fullRouteName)) {
            return $fullRouteName[0];
        }

        return '';
    }

    /**
     * @param string $local
     */
    public function setLocal(string $local)
    {
        $this->request->setLocale($local);
    }

    /**
     * Get Env variables
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getEnv(string $key, mixed $default = null): mixed
    {
        return $this->request->server->get($key, $default);
    }
}