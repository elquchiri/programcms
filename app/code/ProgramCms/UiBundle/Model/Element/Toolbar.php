<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element;

/**
 * Class Toolbar
 * @package ProgramCms\UiBundle\Model\Element
 */
class Toolbar
{
    /**
     * @var array
     */
    private array $buttons = [];

    /**
     * @param $buttonTitle
     * @param $buttonURL
     * @param $buttonType
     * @param null $buttonTarget
     * @return $this
     */
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

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }
}