<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Page;

/**
 * Class Breadcrumb
 * @package ProgramCms\CoreBundle\View\Page
 */
class Breadcrumb
{
    /**
     * @var array
     */
    private array $items = [
        [
            'label' => 'Home',
            'url' => '/'
        ]
    ];

    /**
     * @param array $item
     * @return $this
     */
    public function add(array $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}