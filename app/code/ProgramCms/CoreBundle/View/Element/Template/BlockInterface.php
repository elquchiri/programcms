<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Template;

/**
 * Interface BlockInterface
 * @package ProgramCms\CoreBundle\View\Element\Template
 */
interface BlockInterface
{
    /**
     * @return mixed
     */
    public function toHtml();
}