<?php


namespace ElectroForums\UiBundle\Model\Element;


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