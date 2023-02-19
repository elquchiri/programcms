<?php


namespace ElectroForums\ThemeBundle\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('menuAdmin', template: '@ElectroForumsTheme/adminhtml/components/menu_admin.html.twig')]
class MenuAdmin
{
    public array $columns = [];

    public function getAllMenus()
    {

    }
}