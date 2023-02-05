<?php


namespace ElectroForums\UiBundle\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('grid', template: '@ElectroForumsUi/components/grid.html.twig')]
class GridComponent
{
    public array $columns = [];
    public array $data = [];

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getData()
    {
        return $this->data;
    }
}