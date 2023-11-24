<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form;

use Exception;
use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @var BundleManager
     */
    protected BundleManager $bundleManager;
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Fieldset constructor.
     * @param Context $context
     * @param TranslatorInterface $translator
     * @param BundleManager $bundleManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        TranslatorInterface $translator,
        BundleManager $bundleManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->bundleManager = $bundleManager;
        $this->translator = $translator;
    }

    /**
     * @return void
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
                switch($field['type']) {
                    case "text":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Text::class, $fieldName);
                        break;
                    case "textArea":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\TextArea::class, $fieldName);
                        break;
                    case "password":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Password::class, $fieldName);
                        break;
                    case "hidden":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Hidden::class, $fieldName);
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
                    case "image":
                        $fieldBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Image::class, $fieldName);
                        break;
                }
                foreach($field as $fieldAttributeKey => $fieldAttributeValue) {
                    if($fieldAttributeKey == 'type') {
                        continue;
                    }
                    if(in_array($fieldAttributeKey, ['select', 'multiselect'])) {
                        $fieldBlock->setOptions(
                            $this->bundleManager->getContainer()
                                ->get($field['sourceModel'])
                                ->getOptionsArray());
                        continue;
                    }
                    if($fieldAttributeKey == 'value') {
                        if ($providedData instanceof DataObject) {
                            if (!empty($providedData->hasDataUsingMethod($fieldName))) {
                                $fieldBlock->setValue($providedData->getDataUsingMethod($fieldName));
                            }
                        } else {
                            // Populate field by static value
                            if (isset($field['value'])) {
                                $fieldBlock->setValue($field['value']);
                            }
                        }
                        continue;
                    }
                    if(isset($fieldBlock)) {
                        $fieldBlock->setData($fieldAttributeKey, $fieldAttributeValue);
                    }
                }
                $this->setChild($fieldName, $fieldBlock);
            }
        }
    }
}