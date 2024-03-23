<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResultInterface
 * @package ProgramCms\CoreBundle\View\Result
 */
interface ResultInterface
{
    /**
     * @param array $parameters
     * @return Response
     */
    public function render(array $parameters = []): Response;
}