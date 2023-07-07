<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form;

/**
 * Class Form
 * @package ProgramCms\UiBundle\Block\Form
 */
class Form extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/form.html.twig";
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->bundleManager = $bundleManager;
        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function getFieldSets(): array
    {
        $form = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Form::class);
        foreach($this->getData("fieldSets") as $fieldset) {
            $fieldsetElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fieldset::class);
            $fields = $fieldset['fields'];
            foreach($fields as $fieldName => $field) {
                $fieldElement = null;
                switch($field['type']) {
                    case "text":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\Text::class);
                        if(isset($field['placeholder'])) {
                            $fieldElement->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "textArea":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\TextArea::class);
                        if(isset($field['placeholder'])) {
                            $fieldElement->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "password":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\Password::class);
                        if(isset($field['placeholder'])) {
                            $fieldElement->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "select":
                    case "multiselect":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\Select::class);
                        if($field['type'] == 'multiselect') {
                            $fieldElement->setMultiSelect(true);
                        }
                        $fieldElement->setOptions(
                            $this->bundleManager->getContainer()
                                ->get($field['sourceModel'])
                                ->getOptionsArray()
                        );
                        break;
                    case "switcher":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\Switcher::class);
                        break;
                    case "imageUploader":
                        $fieldElement = $this->objectManager->create(\ProgramCms\UiBundle\Model\Element\Form\Fields\ImageUploader::class);
                        break;
                }
                // Common attributes
                $fieldElement->setLabel($field['label']);
                $fieldElement->setName($fieldName);
                if(isset($field['helpMessage'])) {
                    $fieldElement->setHelpMessage($field['helpMessage']);
                }
                if(isset($field['isRequired'])) {
                    $fieldElement->setIsRequired($field['isRequired']);
                }
                if(isset($field['value'])) {
                    $fieldElement->setValue($field['value']);
                }
                $fieldsetElement->addField($fieldElement);
            }

            $form->addFieldset($fieldsetElement);
        }

        return $form->getFieldSets();
    }
}