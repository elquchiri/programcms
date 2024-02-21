<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\View\Element;

use ProgramCms\CoreBundle\View\Element\BlockInterface;

/**
 * Interface UiComponentInterface
 * @package ProgramCms\UiBundle\View\Element
 */
interface UiComponentInterface extends BlockInterface
{
    /**
     * Get component instance name
     * @return string
     */
    public function getName();

    /**
     * Get component name
     * @return string
     */
    public function getComponentName();

    /**
     * Get component configuration
     * @return array
     */
    public function getConfiguration();

    /**
     * @param $name
     * @param UiComponentInterface $component
     * @return mixed
     */
    public function addComponent($name, UiComponentInterface $component);

    /**
     * @param $name
     * @return mixed
     */
    public function getComponent($name);

    /**
     * Get template
     * @return string
     */
    public function getTemplate();

    /**
     * Get component context
     * @return ContextInterface
     */
    public function getContext();

    /**
     * Prepare component configuration
     * @return void
     */
    public function prepare();

    /**
     * Prepare Data Source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource);

    /**
     * Get Data Source data
     * @return mixed
     */
    public function getDataSourceData();

    /**
     * @return mixed
     */
    public function render();
}