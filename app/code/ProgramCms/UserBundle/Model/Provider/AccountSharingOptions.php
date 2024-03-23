<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AccountSharingOptions
 * @package ProgramCms\UserBundle\Model\Provider
 */
class AccountSharingOptions extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
    implements AccountSharingOptionsInterface
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * AccountSharingOptions constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
    }

    /**
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return [
            AccountSharingOptionsInterface::GLOBAL => $this->translator->trans('Global'),
            AccountSharingOptionsInterface::PER_WEBSITE => $this->translator->trans('Per Website'),
            AccountSharingOptionsInterface::PER_WEBSITE_VIEW => $this->translator->trans('Per Website View')
        ];
    }
}