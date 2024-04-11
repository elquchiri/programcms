<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use Exception;
use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class Field
 * @package ProgramCms\UiBundle\Component\Form
 */
class Field extends \ProgramCms\UiBundle\Component\Form\Element\AbstractElement
{
    const NAME = 'field';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/field.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function prepare()
    {
        parent::prepare();
        $layout = $this->getLayout();
        if($this->hasType()) {
            $fieldName = $this->getName();
            $type = $this->getType();
            $element = $this->getContext()
                ->getUiComponentFactory()
                ->create(
                    $type,
                    $this->getId() . '_field',
                    array_merge_recursive($this->getData(), ['name' => $this->getName()]),
                    $layout
                );
            $element->setName($fieldName);

            if($this->hasData('source')) {
                $dataSourceName = $this->getData('source');
                /** @var AbstractComponent $dataSourceBlock */
                $dataSourceBlock = $this->getLayout()->getBlock($dataSourceName);
                $dataSourceData = $this->getContext()->getDataSourceData($dataSourceBlock);
                $item = current($dataSourceData);
                if ($item && $item->hasData($fieldName)) {
                    $element->setValue($item->getData($fieldName));
                }
            }

            $this->setChild($element->getName(), $element);
        }
    }
}