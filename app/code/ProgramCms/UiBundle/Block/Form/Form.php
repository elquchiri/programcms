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
    protected string $_template = "@ProgramCmsUiBundle/form/form.html.twig";

    protected \ProgramCms\UiBundle\Model\Element\Form\Fieldset $fieldset;
    protected \ProgramCms\UiBundle\Model\Element\Form\Fields\Text $text;
    protected \ProgramCms\UiBundle\Model\Element\Form\Fields\TextArea $textArea;
    protected \ProgramCms\UiBundle\Model\Element\Form\Form $form;
    protected \ProgramCms\UiBundle\Model\Element\Form\Fields\Select $select;
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    protected \ProgramCms\UiBundle\Model\Element\Form\Fields\Password $password;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\UiBundle\Model\Element\Form\Form $form,
        \ProgramCms\UiBundle\Model\Element\Form\Fieldset $fieldset,
        \ProgramCms\UiBundle\Model\Element\Form\Fields\Text $text,
        \ProgramCms\UiBundle\Model\Element\Form\Fields\TextArea $textArea,
        \ProgramCms\UiBundle\Model\Element\Form\Fields\Password $password,
        \ProgramCms\UiBundle\Model\Element\Form\Fields\Select $select,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->fieldset = $fieldset;
        $this->text = $text;
        $this->textArea = $textArea;
        $this->password = $password;
        $this->form = $form;
        $this->select = $select;
        $this->bundleManager = $bundleManager;
    }

    public function getFieldSets(): array
    {
        foreach($this->getData("fieldSets") as $fieldset) {
            $fieldsetElement = clone $this->fieldset;
            $fields = $fieldset['fields'];
            foreach($fields as $fieldName => $field) {
                $fieldElement = null;
                switch($field['type']) {
                    case "text":
                        $fieldElement = clone $this->text;
                        $fieldElement->setPlaceholder($field['placeholder']);
                        break;
                    case "textArea":
                        $fieldElement = clone $this->textArea;
                        $fieldElement->setPlaceholder($field['placeholder']);
                        break;
                    case "password":
                        $fieldElement = clone $this->password;
                        $fieldElement->setPlaceholder($field['placeholder']);
                        break;
                    case "select":
                        $fieldElement = clone $this->select;
                        $fieldElement->setOptions(
                            $this->bundleManager->getContainer()
                                ->get($field['sourceModel'])
                                ->getOptionsArray()
                        );
                        break;
                }
                // Common attributes
                $fieldElement->setLabel($field['label']);
                $fieldElement->setName($fieldName);
                if(isset($field['helpMessage'])) {
                    $fieldElement->setHelpMessage($field['helpMessage']);
                }
                $fieldsetElement->addField($fieldElement);
            }

            $this->form->addFieldset($fieldsetElement);
        }

        return $this->form->getFieldSets();
    }
}