<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Provider\DataSource;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EnableDisable
 * @package ProgramCms\CatalogBundle\Model\Provider\DataSource
 */
class DisplayMode extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
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
            "1" => $this->translator->trans("Only Categories"),
            "2" => $this->translator->trans("Categories and Posts")
        ];
    }
}