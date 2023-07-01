<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Service;

/**
 * Class Response
 * @package ProgramCms\RouterBundle\Service
 */
class Response
{
    protected Request $request;
    private \Twig\Environment $twig;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \Twig\Environment $twig
    )
    {
        $this->twig = $twig;
        $this->request = $request;
    }
}