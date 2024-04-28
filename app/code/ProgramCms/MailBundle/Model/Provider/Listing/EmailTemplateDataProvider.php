<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Model\Provider\Listing;

use ProgramCms\MailBundle\Model\Collection\EmailTemplateCollection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class EmailTemplateDataProvider
 * @package ProgramCms\MailBundle\Model\Provider\Listing
 */
class EmailTemplateDataProvider extends AbstractDataProvider
{
    /**
     * EmailTemplateDataProvider constructor.
     * @param EmailTemplateCollection $collection
     */
    public function __construct(
        EmailTemplateCollection $collection
    )
    {
        $this->collection = $collection;
    }
}