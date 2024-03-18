<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class FlyweightFactory
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
class FlyweightFactory
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var string[]
     */
    protected array $_flyweightMap = [
        'section' => \ProgramCms\ConfigBundle\Model\Structure\Element\Section::class,
        'group' => \ProgramCms\ConfigBundle\Model\Structure\Element\Group::class,
        'field' => \ProgramCms\ConfigBundle\Model\Structure\Element\Field::class
    ];

    /**
     * FlyweightFactory constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param $type
     * @return object|null
     */
    public function create($type): ?object
    {
        return $this->objectManager->create($this->_flyweightMap[$type]);
    }
}