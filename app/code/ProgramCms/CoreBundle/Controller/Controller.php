<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

/**
 * Class Controller
 * @package ProgramCms\CoreBundle\Controller
 */
abstract class Controller extends AbstractController
{

    /**
     * Dispatch Request
     * @return mixed
     * @throws \HttpResponseException
     */
    public function dispatch(): mixed
    {
        $result = $this->execute();
        if($result instanceof \ProgramCms\CoreBundle\View\Result\Page) {
            return $this->execute()->render();
        }
        else if($result instanceof \Symfony\Component\HttpFoundation\RedirectResponse) {
            return $result;
        }

        throw new \HttpResponseException("Result instance expected.");
    }
}