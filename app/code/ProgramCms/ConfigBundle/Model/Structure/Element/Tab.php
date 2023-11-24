<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

/**
 * Class Tab
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
class Tab extends AbstractComposite
{
    /**
     * Tab constructor.
     * @param \ProgramCms\ConfigBundle\App\Context $context
     * @param Iterator\Section $childrenIterator
     */
    public function __construct(
        \ProgramCms\ConfigBundle\App\Context $context,
        \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator\Section $childrenIterator
    )
    {
        parent::__construct($context, $childrenIterator);
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->hasChildren();
    }
}