<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element;


class Toolbar
{
    private array $buttons = [];

    public function addButton($buttonTitle, $buttonURL, $buttonType, $buttonTarget = null): Toolbar
    {
        $this->buttons[] = [
            'label' => $buttonTitle,
            'buttonAction' => $buttonURL,
            'buttonType' => $buttonType,
            'buttonTarget' => $buttonTarget
        ];

        return $this;
    }

    public function getButtons(): array
    {
        return $this->buttons;
    }
}