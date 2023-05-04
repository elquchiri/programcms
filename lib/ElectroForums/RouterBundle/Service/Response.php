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

    protected \Symfony\Component\HttpFoundation\RequestStack $requestStack;
    private \Twig\Environment $twig;

    public function __construct(
        \Symfony\Component\HttpFoundation\RequestStack $requestStack,
        \Twig\Environment $twig
    )
    {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    public function render($parameters = []): \Symfony\Component\HttpFoundation\Response
    {
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