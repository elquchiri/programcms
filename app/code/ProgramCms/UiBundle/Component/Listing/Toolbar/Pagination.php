<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Toolbar;

/**
 * Class Pagination
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class Pagination extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'pagination';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar/pagination.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}