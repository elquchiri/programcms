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
 * Class Select
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
     * @return mixed
     * @throws ReflectionException
     */
    protected function getOptionsData()
    {
        return $this->getContext()
            ->getObjectManager()->create($this->getData('sourceModel'))
            ->getOptionsArray();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getOptions(): string
    {
        $options = $this->getOptionsData();

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
                $isSelected = $this->hasValue() && in_array($key, explode(',', $this->getValue())) ? 'selected' : '';
                $html .= "<option value='". $key ."' ". $isSelected .">". $item . "</option>";
            }
        }
        return $html;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getPlaceholder(): string
    {
        $data = $this->getOptionsData();
        if(count($data)) {
            $firstOption = reset($data);
            if(is_array($firstOption)) {
                return $this->trans('Select one or multiple options');
            }
            return $firstOption;
        }
        return $this->trans('Select one or multiple options');
    }

    /**
     * @return false
     */
    public function isMultiple()
    {
        return false;
    }
}