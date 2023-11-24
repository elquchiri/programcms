<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element\Iterator;

/**
 * Class Group
 * @package ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
 */
class Group extends \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
{
    /**
     * Group constructor.
     * @param \ProgramCms\ConfigBundle\Model\Structure\Element\Group $element
     */
    public function __construct(\ProgramCms\ConfigBundle\Model\Structure\Element\Group $element)
    {
        parent::__construct($element);
    }
}