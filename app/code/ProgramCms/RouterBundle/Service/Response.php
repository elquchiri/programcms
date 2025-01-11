<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Service;

use Twig\Environment;

/**
 * Class Response
 * @package ProgramCms\RouterBundle\Service
 */
class Response
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * Response constructor.
     * @param Request $request
     * @param Environment $twig
     */
    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        Environment $twig
    )
    {
        $this->twig = $twig;
        $this->request = $request;
    }
}