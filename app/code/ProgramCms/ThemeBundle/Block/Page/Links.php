<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page;

use ProgramCms\CoreBundle\View\Element\AbstractBlock;
use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Links
 * @package ProgramCms\ThemeBundle\Block\Page
 */
class Links extends Template
{
    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->layout->getChildBlocks($this->getNameInLayout());
    }

    /**
     * @param $path
     * @return mixed
     */
    protected function getLinkByPath($path)
    {
        foreach ($this->getLinks() as $link) {
            if ($link->getPath() == $path) {
                return $link;
            }
        }
        return '';
    }

    /**
     * @param $path
     */
    public function setActive($path)
    {
        $link = $this->getLinkByPath($path);
        if ($link) {
            $link->setIsHighlighted(true);
        }
    }

    /**
     * @param AbstractBlock $link
     * @return string
     * @throws \Exception
     */
    public function renderLink(AbstractBlock $link)
    {
        return $this->layout->renderElement($link->getNameInLayout());
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function _toHtml(): string
    {
        if (false != $this->hasTemplate()) {
            return parent::_toHtml();
        }

        $maxItems = 5;

        $html = '';
        if ($this->getLinks()) {
            $html = '<ul' . ($this->hasCssClass() ? ' class="' . $this->getCssClass() . '"' : '') . '>';
            foreach ($this->getLinks() as $link) {
                $html .= $this->renderLink($link);
            }
            $html .= '</ul>';
        }

        return $html;
    }
}