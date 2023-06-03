<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\RouterBundle\Service;

use Symfony\Component\Form\FormInterface;


class Response
{
    protected Request $request;
    private \Twig\Environment $twig;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \Twig\Environment $twig
    )
    {
        $this->twig = $twig;
        $this->request = $request;
    }

    public function render($parameters = []): \Symfony\Component\HttpFoundation\Response
    {
        $currentRouteName = $this->request->getCurrentRouteName();
        $content = $this->twig->render($currentRouteName);

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