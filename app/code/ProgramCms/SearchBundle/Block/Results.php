<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\SearchBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Results
 * @package ProgramCms\SearchBundle\Block
 */
class Results extends Template
{
    /**
     * Results constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getSearchResults()
    {
        $request = $this->getRequest();
    }
}