<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\UiBundle\View\Element\UiComponentInterface;

/**
 * Class AbstractComponent
 * @package ProgramCms\UiBundle\Component
 */
abstract class AbstractComponent extends Template implements UiComponentInterface
{
    /**
     * @var array
     */
    protected array $components;
    /**
     * @var Context
     */
    protected Context $context;

    /**
     * AbstractComponent constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = [],
    )
    {
        parent::__construct($context->getTemplateContext(), $data);
        $this->data = array_replace_recursive($this->data, $data);
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getNameInLayout();
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Prepare component configuration
     */
    public function prepare()
    {
        $layout = $this->getLayout();
        $componentName = $this->getNameInLayout();

        foreach($this->getData() as $elementName => $elementConfig) {
            if(is_array($elementConfig)) {
                if ($elementName == 'data') {
                    // Pass component's data section to template
                    $this->addData($elementConfig);
                }
                else if ($elementName == 'buttons') {
                    // Toolbar's Buttons
                        $toolbarActions = $layout->createBlock(
                            \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions::class,
                            'toolbar.actions',
                            $elementConfig
                        );
                        $layout->setChild('buttons.bar', $toolbarActions->getNameInLayout());
                        $toolbarActions->setLayout($layout);
                }
                else if ($elementName == 'dataSource') {
                    if(isset($elementConfig['dataProvider'])) {
                        $dataProvider = $elementConfig['dataProvider'];
                        if(isset($dataProvider['class'])) {
                            /** @var AbstractDataProvider $dataProviderObject */
                            $dataProviderObject = $this->getContext()->getObjectManager()->create($dataProvider['class']);
                            if(isset($dataProvider['primaryFieldName'])) {
                                $dataProviderObject->setPrimaryFieldName($dataProvider['primaryFieldName']);
                            }
                            if(isset($dataProvider['requestFieldName'])) {
                                $dataProviderObject->setRequestFieldName($dataProvider['requestFieldName']);
                            }

                            // Add Data Provider to Context
                            $this->getContext()->setDataProvider($componentName, $dataProviderObject);
                        }
                    }
                }
                // Layout
//                else if ($elementConfig['name'] == 'layout') {
//                    $layoutConfig = $elementConfig['children']['layout'];
//                    $navContainerName = $layoutConfig['navContainerName'] ?? 'left';
//                    $layoutType = $layoutConfig['type'];
//                    // Clean navContainer by removing current elements, keeping only tabs
//                    $layout->cleanElementChildren($navContainerName);
//                    $tabsBlock = $layout->createBlock(
//                        \ProgramCms\UiBundle\Block\Tabs\Tabs::class,
//                        'tabs',
//                        ['label' => $this->hasLabel() ? $this->getLabel() : '', 'sections' => []]
//                    );
//                    $layout->setChild($navContainerName, 'tabs');
//                    $tabsBlock->setLayout($layout);
//                }
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public function getConfiguration($key = '')
    {
        if(isset($key) && !empty($key)) {
            return $this->getData('data')[$key];
        }
        return (array)$this->getData('data');
    }

    /**
     * @param $name
     * @param UiComponentInterface $component
     * @return mixed|void
     */
    public function addComponent($name, UiComponentInterface $component)
    {
        $this->components[$name] = $component;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getComponent($name)
    {
        return $this->components[$name] ?? null;
    }

    /**
     * Prepare Data Source
     * Add or Remove Data
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        return $dataSource;
    }

    /**
     * @return array
     */
    public function getDataSourceData()
    {
        return [];
    }

    /**
     * @return void
     */
    protected function _prepareLayout()
    {
        $this->prepare();
    }
}