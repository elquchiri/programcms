<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\Provider\DataSource;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class RedirectTypes
 * @package ProgramCms\RewriteBundle\Model\Provider\DataSource
 */
class RedirectTypes extends Options
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * RedirectTypes constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(
        TranslatorInterface $translator
    )
    {
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        return [
            0 => 'None',
            401 => $this->translator->trans('401 Permanent Redirection')
        ];
    }
}