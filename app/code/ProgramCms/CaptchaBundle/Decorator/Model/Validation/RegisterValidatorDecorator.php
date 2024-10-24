<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CaptchaBundle\Decorator\Model\Validation;

use Gregwar\Captcha\CaptchaBuilder;
use ProgramCms\CaptchaBundle\Helper\Config;
use ProgramCms\CoreBundle\App\RequestInterface;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Model\Validation\RegisterValidator;
use ProgramCms\UserBundle\Model\Validation\RegisterValidatorInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;

/**
 * Class RegisterValidatorDecorator
 * @package ProgramCms\CaptchaBundle\Decorator\Model\Validation
 */
#[AsDecorator(
    decorates: RegisterValidatorInterface::class,
    priority: 10
)]
class RegisterValidatorDecorator implements RegisterValidatorInterface
{
    /**
     * @var RegisterValidator
     */
    protected RegisterValidator $subject;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * RegisterValidatorDecorator constructor.
     * @param RegisterValidator $subject
     * @param RequestInterface $request
     * @param Config $config
     */
    public function __construct(
        #[MapDecorated] RegisterValidator $subject,
        RequestInterface $request,
        Config $config
    )
    {
        $this->request = $request;
        $this->subject = $subject;
        $this->config = $config;
    }

    /**
     * @param UserEntity $user
     * @param array $data
     * @return array
     */
    public function validate(UserEntity $user, array $data = []): array
    {
        $errors = $this->subject->validate($user, $data);
        if($this->config->isCaptchaEnabledInRegister()) {
            if ($this->request->getCurrentRequest()->isMethod('POST')) {
                $userInput = $this->request->getParam('captcha_verify');
                $builder = new CaptchaBuilder(
                    $this->request->getCurrentRequest()->getSession()->get('phrase')
                );
                if (!$builder->testPhrase($userInput)) {
                    $errors[] = "Invalid Captcha.";
                }
            }
        }
        return $errors;
    }
}