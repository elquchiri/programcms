<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Validation;

use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class RegisterValidator
 * @package ProgramCms\UserBundle\Model\Validation
 */
class RegisterValidator implements RegisterValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * RegisterValidator constructor.
     * @param ValidatorInterface $validator
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ValidatorInterface $validator,
        TranslatorInterface $translator
    )
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }

    /**
     * @param UserEntity $user
     * @param array $data
     * @return array
     */
    public function validate(UserEntity $user, array $data = []): array
    {
        $errors = [];
        foreach($this->validator->validate($user) as $error) {
            $errors[] = str_replace(['{{ value }}'], [$data[$error->getPropertyPath()]], $this->translator->trans($error->getMessageTemplate()));
        }
        return $errors;
    }
}