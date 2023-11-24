<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

/**
 * Class Group
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
class Group extends AbstractComposite
{
    /**
     * Group constructor.
     * @param Iterator\Field $childrenIterator
     */
    public function __construct(
        \ProgramCms\ConfigBundle\App\Context $context,
        \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator\Field $childrenIterator
    )
    {
        parent::__construct($context, $childrenIterator);
    }
}