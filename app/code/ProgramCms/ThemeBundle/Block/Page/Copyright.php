<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Copyright
 * @package ProgramCms\ThemeBundle\Block\Page
 */
class Copyright extends Template
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Copyright constructor.
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
     * @return string
     */
    protected function _toHtml(): string
    {
        return $this->translator->trans(
            "Copyright &copy; 2022-present ProgramCMS Community Edition"
        );
    }
}