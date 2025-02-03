<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CaptchaBundle\Block;

use ProgramCms\CaptchaBundle\Helper\Config;
use ProgramCms\CoreBundle\View\Element\Template;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Class Captcha
 * @package ProgramCms\CaptchaBundle\Block
 */
class Captcha extends Template
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Captcha constructor.
     * @param Template\Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Config $config,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getCaptchaImage(): string
    {
        $builder = new CaptchaBuilder;
        $builder->build(150, 30);
        $this->getRequest()->getCurrentRequest()->getSession()
            ->set('phrase', $builder->getPhrase());
        return $builder->inline();
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isCaptchaEnabledInRegister();
    }
}