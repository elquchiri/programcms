<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Tabs;

use ProgramCms\UiBundle\Component\Form\Fieldset;
use ProgramCms\UiBundle\Component\Form\Form;

/**
 * Class Tabs
 * @package ProgramCms\UiBundle\Block\Tabs
 */
class Tabs extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUi/tabs/tabs.html.twig";

    /**
     * @return string
     */
    public function getTabLabel(): string
    {
        return $this->trans($this->getLabel());
    }

    /**
     * Prepare and provide tabs
     * @return array
     */
    public function getTabs(): array
    {
        $tabs = [];
        $component = $this->getComponent();
        if($component instanceof Form) {
            $fieldsets = $component->getChildBlocks();
            $first = reset($fieldsets);
            foreach($fieldsets as $fieldset) {
                if($fieldset instanceof Fieldset) {
                    $label = $fieldset->hasLabel() ? $fieldset->getLabel() : "";
                    $tabs[$fieldset->getNameInLayout()] = [
                        'active' => $fieldset->getNameInLayout() == $first->getNameInLayout(),
                        'label' => $label
                    ];
                }
            }
        }

        return $tabs;
    }
}