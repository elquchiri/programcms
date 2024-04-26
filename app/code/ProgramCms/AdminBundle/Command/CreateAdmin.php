<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Command;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    const VALID_ACCOUNT_LOCKS = [0, 1];

    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * CreateAdmin constructor.
     * @param AdminUserRepository $adminUserRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param string|null $name
     */
    public function __construct(
        AdminUserRepository $adminUserRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        string $name = null
    )
    {
        $this->adminUserRepository = $adminUserRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        parent::__construct($name);
    }

    /**
     * Command Configuration
     */
    protected function configure()
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'Admin Email Address')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin Password')
            ->addOption('is_active', 'active', InputOption::VALUE_REQUIRED, 'Admin Account Lock')
            ->addOption('firstname', 'fname', InputOption::VALUE_REQUIRED, 'Admin First Name')
            ->addOption('lastname', 'lname', InputOption::VALUE_REQUIRED, 'Admin Last Name')
            ->addOption('locale', 'loc', InputOption::VALUE_REQUIRED, 'Admin Interface Locale')
            ->setDescription('Creates a new Admin')
            ->setHelp('This command creates a new admin user account');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $firstname = $input->getOption('firstname');
        $lastname = $input->getOption('lastname');
        $isActive = $input->getOption('is_active');
        $locale = $input->getOption('locale');

        if(!isset($email) || empty($email)) {
            $output->writeln('Invalid Email Address Provided !');
            return Command::INVALID;
        }

        if(!isset($password) || empty($password)) {
            $output->writeln('Invalid Password Provided !');
            return Command::INVALID;
        }

        if(isset($isActive) || !empty($isActive)) {
            if(is_numeric($isActive) && in_array($isActive, [0, 1])) {
                $isActive = self::VALID_ACCOUNT_LOCKS[$isActive];
            }
            elseif(is_bool($isActive)) {
                $isActive = (int) $isActive;
            }
            else {
                $output->writeln('Invalid Account Lock Provided, valid values: [0, 1, true, false]');
                return Command::INVALID;
            }
        }

        if(!isset($locale) || empty($locale)) {
            $locale = 'en_US';
        }

        $adminUser = new AdminUser();
        $adminUser
            ->setEmail($email)
            ->setFirstName($firstname ?? '')
            ->setLastName($lastname ?? '')
            ->setRoles(['ROLE_ADMIN'])
            ->setIsActive($isActive ?? 1)
            ->setInterfaceLocale($locale)
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $adminUser,
                    $password
                )
            );

        try {
            $this->adminUserRepository->save($adminUser);
            $output->writeln(
                sprintf('Admin %s Created Successfully.', $adminUser->getEmail())
            );
            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $output->writeln('Error Occurred while saving Admin User');
            return Command::FAILURE;
        }
    }
}