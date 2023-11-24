<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element\Iterator;

/**
 * Class Tab
 * @package ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
 */
class Section extends \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
{
    /**
     * Tab constructor.
     * @param \ProgramCms\ConfigBundle\Model\Structure\Element\Section $element
     */
    public function __construct(\ProgramCms\ConfigBundle\Model\Structure\Element\Section $element)
    {
        parent::__construct($element);
    }
}