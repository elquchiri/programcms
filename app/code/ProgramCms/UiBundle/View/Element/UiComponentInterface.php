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
     * Component data setter
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function setData($argument, mixed $value = null): static;

    /**
     * Component data getter
     * @param string $key
     * @param string|int $index
     * @return mixed
     */
    public function getData($argument = null): mixed;

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
     * @return array
     */
    public function getDataSourceData();
}