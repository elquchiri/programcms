<?php


namespace ElectroForums\UiBundle\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('website_switcher', template: '@ElectroForumsUi/components/website_switcher.html.twig')]
class WebsiteSwitcherComponent
{
    public array $buttons = [];

    public function getWebsiteTree(): array
    {
        return $this->buttons;
    }
}