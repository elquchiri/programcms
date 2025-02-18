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
 * Class Search
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class Search extends AbstractComponent
{
    const NAME = 'search';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar/search.html.twig";

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
    public function getValue(): string
    {
        return $this->getRequest()->getParam('keyword_search');
    }
}