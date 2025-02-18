<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class Toolbar
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Toolbar extends AbstractComponent
{
    const NAME = 'toolbar';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return int
     */
    public function countItems()
    {
        $parentName = $this->getLayout()->getParentName($this->getNameInLayout());
        $parentBlock = $this->getLayout()->getBlock($parentName);
        $dataSourceData = $this->getContext()->getDataSourceData($parentBlock);
        return count($dataSourceData);
    }
}