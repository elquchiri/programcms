<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Page;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Copyright
 * @package ProgramCms\AdminBundle\Block\Page
 */
class Copyright extends \ProgramCms\CoreBundle\View\Element\Template
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
     * Returns current year for copyright
     * @return string
     */
    public function getCopyrightYear(): string
    {
        return date("Y");
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        return sprintf(
            $this->translator->trans("Copyright &copy; %s ProgramCMS Community Edition. All rights reserved."),
            $this->getCopyrightYear()
        );
    }
}