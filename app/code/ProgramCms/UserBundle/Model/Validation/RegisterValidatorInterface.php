<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Validation;

use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Interface RegisterValidatorInterface
 * @package ProgramCms\UserBundle\Model\Validation
 */
interface RegisterValidatorInterface
{
    /**
     * @param UserEntity $user
     * @param array $data
     * @return array
     */
    public function validate(UserEntity $user, array $data = []): array;
}