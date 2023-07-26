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
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

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
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\RouterBundle\Service\Request $request,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $objectManager;
        $this->request = $request;
    }

    /**
     * Get form name in layout
     * @return string
     */
    public function getName(): string
    {
        return $this->getNameInLayout();
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();
        $useLayout = false;
        $tabs = [];

        if($this->hasData('layout')) {
            $useLayout = true;
            // Tabs
            $tabs = ['label' => $this->hasLabel() ? $this->getLabel() : '', 'sections' => []];
        }
        // Data from DataProvider
        $data = [];
        if($this->hasData('dataProvider')) {
            $config = $this->getData('dataProvider');
            /** @var AbstractDataProvider $dataProvider */
            $dataProvider = $this->objectManager->create($config['class']);
            $data = $dataProvider->getData();
            if(isset($config['primaryFieldName']) && isset($config['requestFieldName'])) {
                $entityId = (int) $this->request->getParam($config['requestFieldName']);
                $data = $dataProvider
                    ->getCollection()
                    ->filter(function($entity) use($entityId, $config) {
                        return $entity[$config['primaryFieldName']] === $entityId;
                    })
                    ->current();
            }
        }

        if($this->hasData('buttons')) {
            $toolbarActions = $layout->createBlock(
                \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions::class,
                'toolbar.actions',
                $this->getData('buttons')
            );
            $layout->setChild('buttons.bar', $toolbarActions->getNameInLayout());
            $toolbarActions->setLayout($layout);
        }

        if($this->hasData('fieldsets')) {
            $iterator = 1;
            foreach($this->getData('fieldsets') as $name => $fieldset) {
                $tabs['sections'][$name] = ['label' => $fieldset['label'] ?? '', 'active' => !$useLayout || $iterator == 1];
                $fieldsetAlias = 'fieldset-' . $name;
                $collapseBlock = $layout->createBlock(
                    \ProgramCms\UiBundle\Block\Collapser\Collapser::class,
                    $name,
                    [
                        'label' => $fieldset['label'] ?? '',
                        'open' => $useLayout ? true : $fieldset['open'] ?? false,
                        'display' => !$useLayout || $iterator == 1,
                        'collapse' => !$useLayout
                    ]
                );
                if(isset($fieldset['fields'])) {
                    $fieldsetBlock = $layout->createBlock(
                        \ProgramCms\UiBundle\Block\Form\Fieldset::class,
                        $fieldsetAlias,
                        !empty($data) ? array_merge($fieldset, ['providedData' => $data]) : $fieldset
                    );
                    $fieldsetBlock->setLayout($layout);
                    $collapseBlock->setChild($name, $fieldsetBlock);
                }
                if(isset($fieldset['grid'])) {
                    $fieldsetBlock = $layout->createBlock(
                        \ProgramCms\UiBundle\Block\Grid\Grid::class,
                        $fieldsetAlias,
                        $fieldset['grid']
                    );
                    $fieldsetBlock->setLayout($layout);
                    $collapseBlock->setChild($fieldsetAlias, $fieldsetBlock);
                }
                $this->setChild($name, $collapseBlock);
                $iterator++;
            }
        }

        if($useLayout) {
            $layoutConfig = $this->getData('layout');
            $navContainerName = $layoutConfig['navContainerName'] ?? 'left';
            $layoutType = $layoutConfig['type'];
            // Clean navContainer by removing current elements, keeping only tabs
            $layout->cleanElementChildren($navContainerName);
            $tabsBlock = $layout->createBlock(
                \ProgramCms\UiBundle\Block\Tabs\Tabs::class,
                'tabs',
                $tabs
            );
            $layout->setChild($navContainerName, 'tabs');
            $tabsBlock->setLayout($layout);
        }
    }
}