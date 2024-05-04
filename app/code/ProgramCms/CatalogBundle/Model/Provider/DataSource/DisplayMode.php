<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Provider\DataSource;

use ProgramCms\CatalogBundle\Helper\Data;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DisplayMode
 * @package ProgramCms\CatalogBundle\Model\Provider\DataSource
 */
class DisplayMode extends Options
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * DisplayMode constructor.
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
            Data::CATEGORY_DISPLAY_MODE => $this->translator->trans("Only Categories")
        ];
    }
}