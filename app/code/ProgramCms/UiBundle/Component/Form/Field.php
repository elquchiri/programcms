<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use Exception;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\Component\Form\Element\AbstractElement;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Field
 * @package ProgramCms\UiBundle\Component\Form
 */
class Field extends AbstractElement
{
    const NAME = 'field';

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * Field constructor.
     * @param Context $context
     * @param ObjectSerializer $objectSerializer
     * @param array $data
     */
    public function __construct(
        Context $context,
        ObjectSerializer $objectSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectSerializer = $objectSerializer;
    }

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
            if($this->hasData('dataScope')) {
                $fieldName = $this->getDataScope();
            }
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
                // Be sure $dataSourceData contains only one record
                $item = current($dataSourceData);
                if ($item) {
                    $data = $item->getDataUsingMethod($fieldName);
                    if($data instanceof AbstractEntity) {
                        $element->setValue($item->getDataUsingMethod($fieldName)->getDataUsingMethod('entity_id'));
                    } else {
                        $element->setValue($item->getDataUsingMethod($fieldName));
                    }
                }
            }

            $this->setChild($element->getName(), $element);
        }
    }
}