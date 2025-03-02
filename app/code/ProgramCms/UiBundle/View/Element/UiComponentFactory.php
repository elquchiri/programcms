<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\View\Element;

use Exception;
use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\Component\Form\Element\Button;
use ProgramCms\UiBundle\Component\Form\Element\Color;
use ProgramCms\UiBundle\Component\Form\Element\Date;
use ProgramCms\UiBundle\Component\Form\Element\Editor;
use ProgramCms\UiBundle\Component\Form\Element\File;
use ProgramCms\UiBundle\Component\Form\Element\Hidden;
use ProgramCms\UiBundle\Component\Form\Element\Image;
use ProgramCms\UiBundle\Component\Form\Element\ImageUploader;
use ProgramCms\UiBundle\Component\Form\Element\MultiSelect;
use ProgramCms\UiBundle\Component\Form\Element\Password;
use ProgramCms\UiBundle\Component\Form\Element\PlainText;
use ProgramCms\UiBundle\Component\Form\Element\Select;
use ProgramCms\UiBundle\Component\Form\Element\Switcher;
use ProgramCms\UiBundle\Component\Form\Element\Text;
use ProgramCms\UiBundle\Component\Form\Element\TextArea;
use ProgramCms\UiBundle\Component\Form\Element\Tree;
use ProgramCms\UiBundle\Component\Form\Field;
use ProgramCms\UiBundle\Component\Form\Fieldset;

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
        'fieldset' => Fieldset::class,
        'field' => Field::class,
        'text' => Text::class,
        'textarea' => TextArea::class,
        'editor' => Editor::class,
        'password' => Password::class,
        'hidden' => Hidden::class,
        'select' => Select::class,
        'multiselect' => MultiSelect::class,
        'date' => Date::class,
        'switcher' => Switcher::class,
        'plainText' => PlainText::class,
        'image' => Image::class,
        'imageUploader' => ImageUploader::class,
        'file' => File::class,
        'color' => Color::class,
        'button' => Button::class,
        'tree' => Tree::class,
    ];

    /**
     * UiComponentFactory constructor.
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($data);
        $this->objectManager = $objectManager;
    }

    /**
     * @param string $identifier
     * @param string $name
     * @param array $arguments
     * @param $layout
     * @return DataObject|AbstractComponent
     * @throws Exception
     */
    public function create(string $identifier, string $name, array $arguments, &$layout): DataObject|AbstractComponent
    {
        $classNamespace = $this->_instances[$identifier] ?? $identifier;
        if(!class_exists($classNamespace)) {
            throw new Exception(sprintf('Unable to create UIComponent, "%s" Not Found.', $identifier));
        }

        return $layout->createBlock($classNamespace, $name, $arguments);
    }
}