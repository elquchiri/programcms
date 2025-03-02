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
        return $this->getRequest()->hasParam('collection_class') && $this->getRequest()->getParam('collection_class') === $this->getCollectionClass() ?
            $this->getRequest()->getParam('keyword_search') : "";
    }

    /**
     * @return string
     */
    public function getCollectionClass(): string
    {
        $collectionClass = $this->getData('collection_class');
        return md5($collectionClass);
    }

    /**
     * @return mixed
     */
    public function getCurrentRequestUri(){
        return $_SERVER['REQUEST_URI'];
    }
}