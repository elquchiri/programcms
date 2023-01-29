<?php


namespace ElectroForums\UiBundle\Model\Element;


class Toolbar
{
    private array $buttons = [];

    public function addButton($buttonTitle, $buttonURL, $buttonType): Toolbar
    {
        $this->buttons[] = [
            'label' => $buttonTitle,
            'url' => $buttonURL,
            'buttonType' => $buttonType
        ];

        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }
}