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
class Column extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'column';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/column.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->hasLabel('label') ? $this->trans($this->getData('label')) : '';
    }
}