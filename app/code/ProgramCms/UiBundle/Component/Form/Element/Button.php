<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Button
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Button extends AbstractElement
{
    const NAME = 'button';

    protected string $_template = "@ProgramCmsUiBundle/form/fields/button.html.twig";

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
    public function getCssClass(): string
    {
        return $this->hasData('css_class') ? $this->getData('css_class') : 'btn btn-primary';
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        $routeName = $this->getData('url');
        return !empty($routeName) ? parent::getUrl($routeName) : '';
    }

    /**
     * @return bool
     */
    public function hasHref(): bool
    {
        return !empty($this->getHref());
    }
}