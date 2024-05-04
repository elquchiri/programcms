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
 * Class SaveCategoryButton
 * @package ProgramCms\CatalogBundle\Model\Provider\Button\Category
 */
class SaveCategoryButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'category_form',
            'label' => 'Save Category'
        ];
    }
}