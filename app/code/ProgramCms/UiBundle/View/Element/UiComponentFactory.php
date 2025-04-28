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
     * @var array
     */
    private array $instances;

    /**
     * UiComponentFactory constructor.
     * @param ObjectManager $objectManager
     * @param array $instances
     * @param array $data
     */
    public function __construct(
        ObjectManager $objectManager,
        array $instances = [],
        array $data = []
    )
    {
        parent::__construct($data);
        $this->instances = $instances;
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
        $classNamespace = $this->instances[$identifier] ?? $identifier;
        if(!class_exists($classNamespace)) {
            throw new Exception(sprintf('Unable to create UIComponent, "%s" Not Found.', $identifier));
        }

        return $layout->createBlock($classNamespace, $name, $arguments);
    }
}