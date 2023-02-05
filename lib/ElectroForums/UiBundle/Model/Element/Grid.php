<?php


namespace ElectroForums\UiBundle\Model\Element;


class Grid
{
    private array $columns = [];
    private array $data = [];

    public function addColumn($title): static
    {
        $this->columns[] = [
            'title' => $title
        ];

        return $this;
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