<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element;

/**
 * Class Grid
 * @package ProgramCms\UiBundle\Model\Element
 */
class Grid
{
    private array $columns = [];
    private array $data = [];
    private array $actions = [];

    public function addColumn($title, $type = 'text'): static
    {
        $this->columns[] = [
            'title' => $title,
            'type'  => $type
        ];

        return $this;
    }

    public function addAction($action)
    {
        return $this->actions[] = $action;
    }

    public function getActions(): array
    {
        return $this->actions ?? [];
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function populate($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}