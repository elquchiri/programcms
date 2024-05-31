<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\NewsletterBundle\Helper\Data as NewsletterDataHelper;

/**
 * Class Newsletter
 * @package ProgramCms\NewsletterBundle\Block
 */
class Newsletter extends Template
{
    /**
     * @var NewsletterDataHelper
     */
    protected NewsletterDataHelper $newsletterDataHelper;

    /**
     * Newsletter constructor.
     * @param Template\Context $context
     * @param NewsletterDataHelper $newsletterDataHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        NewsletterDataHelper $newsletterDataHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->newsletterDataHelper = $newsletterDataHelper;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->newsletterDataHelper->isNewsletterEnabled();
    }
}