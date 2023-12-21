<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\View\Element;

use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class UiComponentFactory
 * @package ProgramCms\UiBundle\View\Element
 */
class UiComponentFactory extends DataObject
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var array|string[]
     */
    protected array $_instances = [
        'fieldset' => \ProgramCms\UiBundle\Component\Form\Fieldset::class,
        'field' => \ProgramCms\UiBundle\Component\Form\Field::class,
        'text' => \ProgramCms\UiBundle\Component\Form\Element\Text::class,
        'hidden' => \ProgramCms\UiBundle\Component\Form\Element\Hidden::class,
        'select' => \ProgramCms\UiBundle\Component\Form\Element\Select::class,
        'multiselect' => \ProgramCms\UiBundle\Component\Form\Element\MultiSelect::class,
        'switcher' => \ProgramCms\UiBundle\Component\Form\Element\Switcher::class
    ];

    /**
     * UiComponentFactory constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(
        ObjectManager $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $identifier
     * @param string $name
     * @param array $arguments
     * @param $layout
     * @return DataObject|AbstractComponent
     */
    public function create(string $identifier, string $name, array $arguments, &$layout): DataObject|AbstractComponent
    {
        return $layout->createBlock($this->_instances[$identifier], $name . $identifier, $arguments);
    }
}