<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class YesNo
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
class YesNo extends Options
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * YesNo constructor.
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
            "0" => $this->translator->trans("No"),
            "1" => $this->translator->trans("Yes")
        ];
    }
}