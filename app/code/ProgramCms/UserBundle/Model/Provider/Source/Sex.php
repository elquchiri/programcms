<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Source;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Sex
 * @package ProgramCms\UserBundle\Model\Provider\Source
 */
class Sex extends Options
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Sex constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return [
            0 => $this->translator->trans('Man'),
            1 => $this->translator->trans('Woman')
        ];
    }
}