<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Command;

use ProgramCms\CoreBundle\Data\Process\Find;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\DataPatchBundle\Repository\DataPatchRepository;
use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ProgramCms\DataPatchBundle\Helper\Data as DataHelper;

/**
 * Class ExecuteDataPatches
 * @package ProgramCms\DataPatchBundle\Command
 */
#[AsCommand(
    name: 'setup:data-patch',
    aliases: ['set:dpt'],
    hidden: false
)]
class ExecuteDataPatches extends Command
{
    /**
     * @var DataPatchRepository
     */
    protected DataPatchRepository $dataPatchRepository;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var Find
     */
    protected Find $find;

    /**
     * ExecuteDataPatches constructor.
     * @param Find $find
     * @param DataPatchRepository $dataPatchRepository
     * @param ObjectManager $objectManager
     * @param string|null $name
     */
    public function __construct(
        Find $find,
        DataPatchRepository $dataPatchRepository,
        ObjectManager $objectManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->dataPatchRepository = $dataPatchRepository;
        $this->objectManager = $objectManager;
        $this->find = $find;
    }

    /**
     * Configure Data Patch
     */
    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to upgrade app data.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Running Data Patches ..',
            '============',
            '',
        ]);

        // Get all bundles
        $bundles = $this->getApplication()->getKernel()->getBundles();
        foreach ($bundles as $bundle) {
            $reflectedBundle = new \ReflectionClass(get_class($bundle));
            $bundlePath = $bundle->getPath();
            $dataPatchDir = $bundlePath . '/' . DataHelper::MIGRATION_DIR;
            // Check if bundle has Migrations
            if (is_dir($dataPatchDir)) {
                $files = iterator_to_array(new \RecursiveIteratorIterator(
                    new \RecursiveCallbackFilterIterator(
                        new \RecursiveDirectoryIterator($dataPatchDir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                        function (\SplFileInfo $current) {
                            return !str_starts_with($current->getBasename(), '.');
                        }
                    ),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                ));
                foreach ($files as $file) {
                    if (!$file->isFile() || !str_ends_with($file->getFilename(), '.' . DataHelper::MIGRATION_EXTENSION)) {
                        continue;
                    }

                    if ($dataPatchClass = $this->find->findClass($file)) {
                        if(!$this->dataPatchRepository->findOneBy([
                            DataHelper::MIGRATION_PATCH_NAME_COLUMN => $dataPatchClass
                        ])) {
                            $this->_runDataPatch($dataPatchClass);
                            $this->_persistDataPatch($dataPatchClass);
                        }
                    }
                }
            }
        }

        $output->writeln('end of process.');

        return Command::SUCCESS;
    }

    /**
     * @param $dataPatchClass
     */
    protected function _persistDataPatch($dataPatchClass)
    {
        $dataPatch = new \ProgramCms\DataPatchBundle\Entity\DataPatch();
        $dataPatch->setPatchName($dataPatchClass)
            ->setCreatedAt(gmdate('d/m/Y'));
        $this->dataPatchRepository->save($dataPatch, true);
    }

    /**
     * @param $dataPatchClass
     */
    protected function _runDataPatch($dataPatchClass)
    {
        try {
            /** @var DataPatchInterface $dataPatchService */
            $dataPatchService = $this->objectManager->create($dataPatchClass);
            $dataPatchService->execute();
        }catch(\Exception $e) {
            // Log & throw errors
        }
    }
}