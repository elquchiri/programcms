<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use Exception;

/**
 * Class Field
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Field extends \ProgramCms\UiBundle\Component\Form\Element\AbstractElement
{
    const NAME = 'field';

    protected string $_template = "@ProgramCmsUiBundle/form/fields/field.html.twig";

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
                    $fieldName,
                    array_merge_recursive($this->getData(), ['name' => $this->getName()]),
                    $layout
                );
            $element->setName($this->getNameInLayout());

            if($this->hasData('source')) {
                $dataSourceName = $this->getData('source');
                $dataSourceData = $this->getContext()->getDataSource($dataSourceName);
                if (!empty($dataSourceData->hasDataUsingMethod($fieldName))) {
                    $element->setValue($dataSourceData->getDataUsingMethod($fieldName));
                }
            }
            $this->setChild($this->getName(), $element->getNameInLayout());
        }
    }
}