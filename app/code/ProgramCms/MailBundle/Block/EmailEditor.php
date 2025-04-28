<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Block;

use ProgramCms\PageBundle\Block\PageEditor;

/**
 * Class EmailEditor
 * @package ProgramCms\MailBundle\Block
 */
class EmailEditor extends PageEditor
{
    /**
     * @return string
     */
    public function getLoadUrl(): string
    {
        return $this->getUrl('mailer_ajax_loadtemplate', [
            'template_id' => $this->getTemplateId()
        ]);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('mailer_index_save');
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->getRequest()->getParam('id');
    }
}