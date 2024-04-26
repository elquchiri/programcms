<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Toolbar;

use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class Filters
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class Filters extends AbstractComponent
{
    const NAME = 'filters';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar/filters.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}