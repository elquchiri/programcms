<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

/**
 * Class Column
 * @package ProgramCms\UiBundle\Component\Listing
 */
class SelectionsColumn extends Column
{
    const NAME = 'selectionsColumn';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/selections_column.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}