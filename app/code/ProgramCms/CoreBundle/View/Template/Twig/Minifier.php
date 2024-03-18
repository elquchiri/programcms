<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Template\Twig;

use ProgramCms\CoreBundle\View\Template\MinifierInterface;

/**
 * Class Minifier
 * @package ProgramCms\CoreBundle\View\Template\Twig
 */
class Minifier implements MinifierInterface
{
    /**
     * @param $file
     * @return mixed
     */
    public function getMinified($file)
    {
        // TODO: Minify file
        return $file;
    }
}