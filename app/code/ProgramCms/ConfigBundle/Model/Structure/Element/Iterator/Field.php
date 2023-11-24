<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element\Iterator;

/**
 * Class Field
 * @package ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
 */
class Field extends \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator
{
    public function __construct(\ProgramCms\ConfigBundle\Model\Structure\Element\Field $element)
    {
        parent::__construct($element);
    }
}