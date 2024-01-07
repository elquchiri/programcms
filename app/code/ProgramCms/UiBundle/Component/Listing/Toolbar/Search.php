<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Toolbar;

/**
 * Class Search
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class Search extends \ProgramCms\UiBundle\Component\AbstractComponent
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

    public function prepareDataSource(array $dataSource)
    {
        // Search
        $search = $this->getRequest()->getParam('search');
        if(!empty($search)) {

        }
        return parent::prepareDataSource($dataSource);
    }
}