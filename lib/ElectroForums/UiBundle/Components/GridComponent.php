<?php


namespace ElectroForums\UiBundle\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('grid', template: '@ElectroForumsUi/components/grid.html.twig')]
class GridComponent
{
    public array $columns = [];
    public array $data = [];
    public array $actions = [];

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getActions(): array
    {
        return $this->actions ?? [];
    }
}