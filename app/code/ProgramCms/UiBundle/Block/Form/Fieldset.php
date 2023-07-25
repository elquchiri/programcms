<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form;

use Exception;

/**
 * Class Fieldset
 * @package ProgramCms\UiBundle\Block\Form
 */
class Fieldset extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fieldset.html.twig";
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->bundleManager = $bundleManager;
    }

    /**
     * @return Fieldset|void
     * @throws Exception
     */
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();
        // Data from DataProvider
        $providedData = [];
        if($this->hasData('fields')) {
            if($this->hasData('providedData')) {
                $providedData = $this->getData('providedData');
            }
            foreach ($this->getData("fields") as $fieldName => $field) {
                switch ($field['type']) {
                    case "text":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Text::class, $fieldName);
                        if (isset($field['placeholder'])) {
                            $fieldBlock->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "textArea":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\TextArea::class, $fieldName);
                        if (isset($field['placeholder'])) {
                            $fieldBlock->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "password":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Password::class, $fieldName);
                        if (isset($field['placeholder'])) {
                            $fieldBlock->setPlaceholder($field['placeholder']);
                        }
                        break;
                    case "select":
                    case "multiselect":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Select::class, $fieldName);
                        if ($field['type'] == 'multiselect') {
                            $fieldBlock->setMultiSelect(true);
                        }
                        $fieldBlock->setOptions(
                            $this->bundleManager->getContainer()
                                ->get($field['sourceModel'])
                                ->getOptionsArray()
                        );
                        break;
                    case "plainText":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\PlainText::class, $fieldName);
                        break;
                    case "switcher":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Switcher::class, $fieldName);
                        break;
                    case "imageUploader":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\ImageUploader::class, $fieldName);
                        break;
                }
                // Common attributes
                if (isset($fieldBlock)) {
                    $fieldBlock->setLabel($field['label']);
                    if (isset($field['helpMessage'])) {
                        $fieldBlock->setHelpMessage($field['helpMessage']);
                    }
                    if (isset($field['isRequired'])) {
                        $fieldBlock->setIsRequired($field['isRequired']);
                    }
                    // Populate field by provided value
                    if(isset($providedData[$fieldName]) && !empty($providedData[$fieldName])) {
                        $fieldBlock->setValue($providedData[$fieldName]);
                    }
                    // Populate field by static value
                    if (isset($field['value'])) {
                        $fieldBlock->setValue($field['value']);
                    }
                    $this->setChild($fieldName, $fieldBlock);
                }
            }
        }
    }
}