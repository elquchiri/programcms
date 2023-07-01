<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class BundleGenerator
 * @package ProgramCms\ManagerBundle\Command
 */
#[AsCommand(
    name: 'bundle:generate',
    aliases: ['bun:gen'],
    hidden: false
)]
class BundleGenerator extends Command
{

    public function __construct(string $name = null)
    {
        // Init class attributes before parent construct te be available
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create new ProgramCMS bundle.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Bundle Generation ..',
            '============',
            '',
        ]);

        return Command::SUCCESS;
    }
}