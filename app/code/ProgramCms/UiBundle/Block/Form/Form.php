<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form;

use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class Form
 * @package ProgramCms\UiBundle\Block\Form
 */
class Form extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/form.html.twig";

    /**
     * Get form name in layout
     * @return string
     */
    public function getName(): string
    {
        return $this->getNameInLayout();
    }

    /**
     * @return Form|void
     * @throws Exception
     */
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();
        if($this->hasData('buttons')) {
            $toolbarActions = $layout->createBlock(\ProgramCms\UiBundle\Block\Toolbar\ToolbarActions::class, 'toolbar.actions', $this->getData('buttons'));
            $layout->setChild('buttons.bar', $toolbarActions->getNameInLayout());
            $toolbarActions->setLayout($layout);
        }
        if($this->hasData('fieldsets')) {
            foreach($this->getData('fieldsets') as $name => $fieldset) {
                $collapseAlias = 'collapse-' . $name;
                $collapseBlock = $layout->createBlock(
                    \ProgramCms\UiBundle\Block\Collapser\Collapser::class,
                    $collapseAlias,
                    ['label' => $fieldset['label'] ?? '', 'open' => $fieldset['open'] ?? false]
                );
                if(isset($fieldset['fields'])) {
                    $fieldsetBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fieldset::class, $name, $fieldset);
                    $fieldsetBlock->setLayout($layout);
                    $collapseBlock->setChild($name, $fieldsetBlock);
                }
                if(isset($fieldset['grid'])) {
                    $fieldsetBlock = $layout->createBlock(\ProgramCms\UiBundle\Block\Grid\Grid::class, $name, $fieldset['grid']);
                    $fieldsetBlock->setLayout($layout);
                    $collapseBlock->setChild($name, $fieldsetBlock);
                }
                $this->setChild($collapseAlias, $collapseBlock);
            }
        }
    }
}