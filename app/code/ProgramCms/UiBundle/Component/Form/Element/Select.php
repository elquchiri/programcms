<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Text
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Select extends AbstractElement
{
    const NAME = 'select';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/select.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->getContext()
            ->getObjectManager()->create($this->getData('sourceModel'))
            ->getOptionsArray();
    }
}