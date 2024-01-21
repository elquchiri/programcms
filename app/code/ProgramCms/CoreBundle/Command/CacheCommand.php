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
 * Class CacheCommand
 * @package ProgramCms\CoreBundle\Command
 */
#[AsCommand(
    name: 'cache',
    aliases: ['c:e'],
    hidden: false
)]
class CacheCommand extends Command
{

}