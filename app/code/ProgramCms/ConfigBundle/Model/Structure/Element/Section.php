<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

/**
 * Class Section
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
class Section extends AbstractComposite
{
    /**
     * Section constructor.
     * @param \ProgramCms\ConfigBundle\App\Context $context
     * @param Iterator\Group $childrenIterator
     */
    public function __construct(
        \ProgramCms\ConfigBundle\App\Context $context,
        \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator\Group $childrenIterator
    )
    {
        parent::__construct($context, $childrenIterator);
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return parent::isVisible();
    }
}