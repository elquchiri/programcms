<?php


namespace ElectroForums\UiBundle\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('toolbar', template: '@ElectroForumsUi/components/toolbar.html.twig')]
class ToolbarComponent
{
    public array $buttons = [];
    public bool $includeWebsiteSwitcher;

    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getIncludeWebsiteSwitcher(): bool
    {
        return $this->includeWebsiteSwitcher;
    }
}