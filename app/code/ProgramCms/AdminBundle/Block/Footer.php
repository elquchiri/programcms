<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block;

/**
 * Class Footer
 * @package ProgramCms\AdminBundle\Block
 */
class Footer extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @return string
     */
    public function getCopyrightYear(): string
    {
        return date("Y");
    }
}