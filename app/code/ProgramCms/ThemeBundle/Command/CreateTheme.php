<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

/**
 * Class CreateTheme
 * @package ProgramCms\ThemeBundle\Command
 */
#[AsCommand(
    name: 'theme:create',
    aliases: ['th:cr'],
    hidden: false
)]
class CreateTheme extends Command
{

}