<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

/**
 * Class CreateAdmin
 * @package ProgramCms\AdminBundle\Command
 */
#[AsCommand(
    name: 'admin:create',
    aliases: ['ad:cr'],
    hidden: false
)]
class CreateAdmin extends Command
{

}