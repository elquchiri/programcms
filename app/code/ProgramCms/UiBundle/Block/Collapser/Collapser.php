<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Collapser;

use JetBrains\PhpStorm\Pure;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Collapser
 * @package ProgramCms\UiBundle\Block\Collapser
 */
class Collapser extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/collapser/collapser.html.twig";
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Collapser constructor.
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
    #[Pure] public function getName(): string
    {
        return $this->getNameInLayout();
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->hasData('label') ? $this->translator->trans($this->getData('label')) : "";
    }

    /**
     * @return bool
     */
    public function hasLabel(): bool
    {
        return $this->hasData('label');
    }

    /**
     * Detects weather collapser is open
     * @return bool
     */
    public function isOpen(): bool
    {
        if (!$this->hasLabel()) {
            return true;
        }
        if ($this->hasData('open')) {
            return $this->getData('open');
        }
        return false;
    }
}