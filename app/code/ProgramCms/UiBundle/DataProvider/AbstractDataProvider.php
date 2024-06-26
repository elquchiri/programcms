<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DataProvider;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Class AbstractDataProvider
 * @package ProgramCms\UiBundle\DataProvider
 */
abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * Data Provider Primary Identifier name
     * @var string
     */
    protected string $primaryFieldName = '';

    /**
     * @var string
     */
    protected string $foreignFieldName = '';

    /**
     * Data Provider Request Parameter Identifier name
     * @var string
     */
    protected string $requestFieldName = '';

    /**
     * Provider configuration data
     * @var array
     */
    protected array $data = [];

    /**
     * @var AbstractCollection
     */
    protected AbstractCollection $collection;

    /**
     * Get primary field name
     * @return string
     */
    public function getPrimaryFieldName(): string
    {
        return $this->primaryFieldName;
    }

    /**
     * Get field name in request
     * @return string
     */
    public function getRequestFieldName(): string
    {
        return $this->requestFieldName;
    }

    /**
     * @return AbstractCollection
     */
    public function getCollection(): AbstractCollection
    {
        return $this->collection;
    }

    /**
     * Get Data
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->getCollection()->getData();
    }

    /**
     * @param string $primaryFieldName
     * @return $this
     */
    public function setPrimaryFieldName(string $primaryFieldName)
    {
        $this->primaryFieldName = $primaryFieldName;
        return $this;
    }

    /**
     * @return string
     */
    public function getForeignFieldName(): string
    {
        return $this->foreignFieldName;
    }

    /**
     * @param string $foreignFieldName
     * @return $this
     */
    public function setForeignFieldName(string $foreignFieldName): static
    {
        $this->primaryFieldName = $foreignFieldName;
        return $this;
    }

    /**
     * @param string $requestFieldName
     * @return $this
     */
    public function setRequestFieldName(string $requestFieldName)
    {
        $this->requestFieldName = $requestFieldName;
        return $this;
    }
}