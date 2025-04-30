<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NotificationBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\UserBundle\Entity\UserEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Notification
 * @package ProgramCms\NotificationBundle\Entity
 */
#[ORM\Entity]
class Notification extends Entity
{
    /**
     * @var UserEntity
     */
    private UserEntity $user;

    /**
     * @var string
     */
    #[ORM\Column(length: 255)]
    private string $notificationCode;

    /**
     * @var array
     */
    #[ORM\Column(type: 'json')]
    private array $config_data;

    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean')]
    private bool $is_read;
}