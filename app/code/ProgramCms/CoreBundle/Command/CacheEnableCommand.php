<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

/**
 * Class CacheEnableCommand
 * @package ProgramCms\CoreBundle\Command
 */
#[AsCommand(
    name: 'cache:enable',
    aliases: ['c:e'],
    hidden: false
)]
class CacheEnableCommand extends Command
{

}