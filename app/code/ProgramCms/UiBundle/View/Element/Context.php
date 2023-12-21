<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\View\Element;

use ProgramCms\CoreBundle\Model\ObjectManager;

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
    protected array $dataSources = [];

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
    public function addDataSource($name, $source)
    {
        $this->dataSources[$name] = $source;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getDataSource(string $name)
    {
        return $this->dataSources[$name] ?? null;
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
}