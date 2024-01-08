<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\UiBundle\View\Element\Context;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Fieldset
 * @package ProgramCms\UiBundle\Block\Form
 */
class Fieldset extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'fieldset';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fieldset.html.twig";
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Fieldset constructor.
     * @param Context $context
     * @param TranslatorInterface $translator
     * @param BundleManager $bundleManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        TranslatorInterface $translator,
        BundleManager $bundleManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->bundleManager = $bundleManager;
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->trans($this->getData('label'));
    }
}