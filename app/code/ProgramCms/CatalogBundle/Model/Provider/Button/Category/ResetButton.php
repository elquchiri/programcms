<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Provider\Button\Category;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class ResetButton
 * @package ProgramCms\CatalogBundle\Model\Provider\Button\Category
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '#',
            'label' => 'Reset'
        ];
    }
}