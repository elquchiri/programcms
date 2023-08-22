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
    /**
     * @var array
     */
    private array $columns = [];
    /**
     * @var array
     */
    private array $data = [];
    /**
     * @var array
     */
    private array $actions = [];

    /**
     * @param string $key
     * @param string $title
     * @param string $type
     * @return $this
     */
    public function addColumn(string $key, string $title, string $type = 'text', string $class = ''): static
    {
        $this->columns[$key] = [
            'title' => $title,
            'type' => $type,
            'class'  => $class
        ];

        return $this;
    }

    /**
     * @param $action
     * @return mixed
     */
    public function addAction($action): static
    {
        $this->actions[] = $action;
        return $this;
    }

    /**
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions): static
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions ?? [];
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param $data
     */
    public function populate($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}