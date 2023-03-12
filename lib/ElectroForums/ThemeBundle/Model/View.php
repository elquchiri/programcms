<?php


namespace ElectroForums\ThemeBundle\Model;


use Twig\Error\LoaderError;

class View
{

//    private \Symfony\Component\DependencyInjection\ContainerInterface $container;
//    private \Symfony\Component\HttpFoundation\RequestStack $requestStack;
//
//    public function __construct(
//        \Symfony\Component\DependencyInjection\ContainerInterface $container,
//        \Symfony\Component\HttpFoundation\RequestStack $requestStack
//    )
//    {
//        $this->container = $container;
//        $this->requestStack = $requestStack;
//    }

    // Template View Path
    private $viewPath;

    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function getViewPath(): string
    {
//        $currentRequest = $this->requestStack->getCurrentRequest();
//        $routeName = $currentRequest->attributes->get('_route');


        $pathParams = explode('/', $this->viewPath);
        $twigNamespace = $pathParams[0];
        $bundleName = str_replace('@', '', $twigNamespace) . 'Bundle';
        array_shift($pathParams);

        // View Path
        $view = implode('/', $pathParams);

        // get current theme
        $theme = '';

        $themePath = '@Themes/' . $theme . '/' . $bundleName . '/';
        $themeViewsPath = $themePath . 'views/';

        if ($theme) {
            // use the specified theme
            return $themeViewsPath . $view;
        }

        // fall back to default behavior if no theme is specified
        return $twigNamespace . '/' . $view;
    }
}