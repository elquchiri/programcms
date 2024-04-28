<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Model\Collection;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\MailBundle\Entity\EmailTemplate;

/**
 * Class EmailTemplateCollection
 * @package ProgramCms\MailBundle\Model\Collection
 */
class EmailTemplateCollection extends AbstractCollection
{
    /**
     * Init Email Template Entity
     */
    protected function _construct()
    {
        $this->_initEntity(EmailTemplate::class);
    }
}