<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\View\Element;

use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class Context
 * @package ProgramCms\UiBundle\View\Element
 */
class Context implements ContextInterface
{
    /**
     * @var \ProgramCms\CoreBundle\View\Element\Template\Context
     */
    protected \ProgramCms\CoreBundle\View\Element\Template\Context $templateContext;
    /**
     * @var array
     */
    protected array $dataProviders = [];

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var UiComponentFactory
     */
    protected UiComponentFactory $uiComponentFactory;

    /**
     * Context constructor.
     * @param \ProgramCms\CoreBundle\View\Element\Template\Context $templateContext
     * @param ObjectManager $objectManager
     * @param UiComponentFactory $uiComponentFactory
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $templateContext,
        ObjectManager $objectManager,
        UiComponentFactory $uiComponentFactory
    )
    {
        $this->templateContext = $templateContext;
        $this->objectManager = $objectManager;
        $this->uiComponentFactory = $uiComponentFactory;
    }

    /**
     * @return \ProgramCms\CoreBundle\View\Element\Template\Context
     */
    public function getTemplateContext()
    {
        return $this->templateContext;
    }

    /**
     * @param $name
     * @param $source
     */
    public function setDataProvider(string $name, AbstractDataProvider $dataProvider)
    {
        $this->dataProviders[$name] = $dataProvider;
    }

    /**
     * @param AbstractComponent $component
     * @return array
     */
    public function getDataSourceData(AbstractComponent $component): array
    {
        $dataSourceData = $component->getDataSourceData();
        $this->prepareDataSource($dataSourceData, $component);
        return $dataSourceData;
    }

    /**
     * @param string $name
     * @return AbstractDataProvider
     * @throws Exception
     */
    public function getDataProvider(string $name): AbstractDataProvider
    {
        if(!isset($this->dataProviders[$name])) {
            throw new Exception(sprintf("No DataProvider found for name %s", $name));
        }
        return $this->dataProviders[$name];
    }

    /**
     * @return array
     */
    public function getDataProviders(): array
    {
        return $this->dataProviders;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager(): ObjectManager
    {
        return $this->objectManager;
    }

    /**
     * @return UiComponentFactory
     */
    public function getUiComponentFactory(): UiComponentFactory
    {
        return $this->uiComponentFactory;
    }

    /**
     * @param array $data
     * @param AbstractComponent $component
     */
    protected function prepareDataSource(array &$data, AbstractComponent $component)
    {
        $childComponents = $component->getChildBlocks();
        if (!empty($childComponents)) {
            foreach ($childComponents as $child) {
                $this->prepareDataSource($data, $child);
            }
        }
        $data = $component->prepareDataSource($data);
    }
}