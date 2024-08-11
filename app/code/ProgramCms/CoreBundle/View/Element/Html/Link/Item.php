<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Html\Link;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Item
 * @package ProgramCms\CoreBundle\View\Element\Html\Link
 */
class Item extends Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Item constructor.
     * @param Template\Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $label = $this->getLabel();
        $path = $this->getPath();
        $url = $this->getUrl($path);
        $currentRouteName = $this->url->getRouteName();
        $isActive = $currentRouteName === $path ? ' active' : '';
        return "<a class=\"nav-link $isActive\" href=\"". $url ."\">". $this->trans($label) ."</a>";
    }
}