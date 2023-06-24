<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

/**
 * Class AbstractResult
 * @package ProgramCms\CoreBundle\View\Result
 */
abstract class AbstractResult implements ResultInterface
{

    /**
     * @return mixed
     */
    abstract public function render();
}