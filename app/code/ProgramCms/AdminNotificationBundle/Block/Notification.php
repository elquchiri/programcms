<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminNotificationBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Notification
 * @package ProgramCms\AdminNotificationBundle\Block
 */
class Notification extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Notification constructor.
     * @param Context $context
     * @param TranslatorInterface $translator
     * @param array $data
     */
    public function __construct(
        Context $context,
        TranslatorInterface $translator,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->translator = $translator;
    }

    /**
     * Get All Notifications
     * @return array
     */
    public function getNotifications(): array
    {
        return [
            'message' => sprintf(
                $this->translator->trans("One or more of the Cache Types are invalidated: Page Cache. Please go to %s and refresh cache types."), "<a href=\"#\">{$this->translator->trans("Cache Management")}</a>")
        ];
    }
}