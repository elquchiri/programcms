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
use RecursiveIteratorIterator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ProgramCms\DataPatchBundle\Helper\Data as DataHelper;
use ReflectionClass;
use ReflectionException;

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
        $this->setHelp('This command allows you to run and apply data patches.');
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
            '============'
        ]);

        // Get all bundles
        $bundles = $this->getApplication()->getKernel()->getBundles();
        foreach ($bundles as $bundle) {
            $bundlePath = $bundle->getPath();
            $dataPatchDir = $bundlePath . '/' . DataHelper::MIGRATION_DIR;
            // Check if bundle has Migrations
            if (is_dir($dataPatchDir)) {
                $files = $this->getPatchFiles($dataPatchDir);

                // Resolve Patches Dependencies
                $patches = $this->preparePatchDependencies($files);
                unset($files);
                foreach ($patches as $patch) {
                    if ($patch) {
                        if(!$this->dataPatchRepository->findOneBy([
                            DataHelper::MIGRATION_PATCH_NAME_COLUMN => $patch
                        ])) {
                            $this->runDataPatch($patch);
                            $this->persistDataPatch($patch);
                        }
                    }
                }
            }
        }
        $output->writeln('end of process.');
        return Command::SUCCESS;
    }

    /**
     * Get Patch Class Namespaces
     * @param $dataPatchDir
     * @return array
     */
    private function getPatchFiles($dataPatchDir): array
    {
        $patchClasses = [];
        $files = iterator_to_array(new RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($dataPatchDir, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                function (\SplFileInfo $current) {
                    return !str_starts_with($current->getBasename(), '.');
                }
            ),
            RecursiveIteratorIterator::LEAVES_ONLY
        ));

        foreach($files as $file) {
            if (!$file->isFile() || !str_ends_with($file->getFilename(), '.' . DataHelper::MIGRATION_EXTENSION)) {
                continue;
            }
            $patchClasses[] = $this->find->findClass($file->getPathname());
        }
        return $patchClasses;
    }

    /**
     * Prepare Patch Dependencies
     * @param array $patches
     * @return array
     * @throws ReflectionException
     */
    private function preparePatchDependencies(array $patches): array
    {
        $patchStack = [];
        $visitedPatches = [];
        $this->resolvePatchesDependencies($patchStack, $visitedPatches, $patches);
        return $patchStack;
    }

    /**
     * @param array $patchStack
     * @param array $visitedPatches
     * @param array $patches
     * @throws ReflectionException
     */
    private function resolvePatchesDependencies(
        array &$patchStack,
        array &$visitedPatches,
        array $patches
    )
    {
        $patches = array_reverse($patches);
        foreach ($patches as $patch) {
            // Each visited node is prioritized and placed at the beginning.
            $this->prioritizePatch($patchStack, $patch);
        }

        foreach ($patches as $patch) {
            $patchNamespace = $patch;
            // Continue if this bundle was already visited
            if (isset($visitedPatches[$patchNamespace])) {
                continue;
            }

            $visitedPatches[$patchNamespace] = true;
            $bundleNamespaceObj = new ReflectionClass($patchNamespace);
            if ($bundleNamespaceObj->implementsInterface(DataPatchInterface::class)) {
                $patchDependencies = $patchNamespace::getDependencies();
                $this->resolvePatchesDependencies($patchStack, $visitedPatches, $patchDependencies);
            }
        }
    }

    /**
     * @param array $patchStack
     * @param $patchToPrioritize
     */
    private function prioritizePatch(array &$patchStack, $patchToPrioritize)
    {
        $elementNamespace = $patchToPrioritize;
        foreach ($patchStack as $patch) {
            $patchNamespace = $patch;

            if ($elementNamespace == $patchNamespace) {
                $classIndex = array_search($patch, $patchStack);
                unset($patchStack[$classIndex]);
            }
        }
        array_unshift($patchStack, $patchToPrioritize);
    }

    /**
     * @param $dataPatchClass
     */
    protected function persistDataPatch($dataPatchClass)
    {
        $dataPatch = new \ProgramCms\DataPatchBundle\Entity\DataPatch();
        $dataPatch->setPatchName($dataPatchClass)
            ->setCreatedAt(gmdate('d/m/Y'));
        $this->dataPatchRepository->save($dataPatch, true);
    }

    /**
     * Run Data Patch
     * @param $dataPatchClass
     */
    protected function runDataPatch($dataPatchClass)
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