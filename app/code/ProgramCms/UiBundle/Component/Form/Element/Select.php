<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

use ReflectionException;

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
     * @return string
     * @throws ReflectionException
     */
    public function getOptions(): string
    {
        $options = $this->getContext()
            ->getObjectManager()->create($this->getData('sourceModel'))
            ->getOptionsArray();

        return $this->processOptionGroup($options);
    }

    /**
     * @param array $group
     * @return string
     */
    private function processOptionGroup(array $group): string
    {
        $html = "";
        foreach($group as $key => $item) {
            if(is_array($item)) {
                $html .= "<optgroup label='". $key ."'>";
                $html .= $this->processOptionGroup($item);
                $html .= "</optgroup>";
            }else{
                $isSelected = $this->hasValue() && $this->getValue() == $key ? 'selected' : '';
                $html .= "<option value='". $key ."' ". $isSelected .">". $item . "</option>";
            }
        }
        return $html;
    }
}