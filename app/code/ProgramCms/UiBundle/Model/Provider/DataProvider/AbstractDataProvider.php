<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataProvider;

/**
 * Class AbstractDataProvider
 * @package ProgramCms\UiBundle\Model\Provider\DataProvider
 */
abstract class AbstractDataProvider implements \ProgramCms\UiBundle\Model\Provider\DataProvider\DataProviderInterface
{
    /**
     * Data Provider name
     *
     * @var string
     */
    protected string $name;

    /**
     * Data Provider Primary Identifier name
     *
     * @var string
     */
    protected string $primaryFieldName;

    /**
     * Data Provider Request Parameter Identifier name
     *
     * @var string
     */
    protected string $requestFieldName;
}