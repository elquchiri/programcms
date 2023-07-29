<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Command;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\DataPatchBundle\Repository\DataPatchRepository;
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
    name: 'data-patch:upgrade',
    aliases: ['dpa:upg'],
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
     * ExecuteDataPatches constructor.
     * @param DataPatchRepository $dataPatchRepository
     * @param ObjectManager $objectManager
     * @param string|null $name
     */
    public function __construct(
        DataPatchRepository $dataPatchRepository,
        ObjectManager $objectManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->dataPatchRepository = $dataPatchRepository;
        $this->objectManager = $objectManager;
    }

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
     * @throws \ReflectionException
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

                    if ($dataPatchClass = $this->findClass($file)) {
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

    protected function _persistDataPatch($dataPatchClass)
    {
        $dataPatch = new \ProgramCms\DataPatchBundle\Entity\DataPatch();
        $dataPatch->setPatchName($dataPatchClass)
            ->setCreatedAt(gmdate('d/m/Y'));
        $this->dataPatchRepository->save($dataPatch, true);
    }

    protected function _runDataPatch($dataPatchClass)
    {
        try {
            $dataPatchService = $this->objectManager->create($dataPatchClass);
            $dataPatchService->execute();
        }catch(\Exception $e) {
            // Log & throw errors
        }
    }

    /**
     * Returns the full class name for the first class in the file.
     */
    protected function findClass(string $file): string|false
    {
        $class = false;
        $namespace = false;
        $tokens = token_get_all(file_get_contents($file));

        if (1 === \count($tokens) && \T_INLINE_HTML === $tokens[0][0]) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain PHP code. Did you forgot to add the "<?php" start tag at the beginning of the file?', $file));
        }

        $nsTokens = [\T_NS_SEPARATOR => true, \T_STRING => true];
        if (\defined('T_NAME_QUALIFIED')) {
            $nsTokens[\T_NAME_QUALIFIED] = true;
        }
        for ($i = 0; isset($tokens[$i]); ++$i) {
            $token = $tokens[$i];
            if (!isset($token[1])) {
                continue;
            }

            if (true === $class && \T_STRING === $token[0]) {
                return $namespace . '\\' . $token[1];
            }

            if (true === $namespace && isset($nsTokens[$token[0]])) {
                $namespace = $token[1];
                while (isset($tokens[++$i][1], $nsTokens[$tokens[$i][0]])) {
                    $namespace .= $tokens[$i][1];
                }
                $token = $tokens[$i];
            }

            if (\T_CLASS === $token[0]) {
                // Skip usage of ::class constant and anonymous classes
                $skipClassToken = false;
                for ($j = $i - 1; $j > 0; --$j) {
                    if (!isset($tokens[$j][1])) {
                        if ('(' === $tokens[$j] || ',' === $tokens[$j]) {
                            $skipClassToken = true;
                        }
                        break;
                    }

                    if (\T_DOUBLE_COLON === $tokens[$j][0] || \T_NEW === $tokens[$j][0]) {
                        $skipClassToken = true;
                        break;
                    } elseif (!\in_array($tokens[$j][0], [\T_WHITESPACE, \T_DOC_COMMENT, \T_COMMENT])) {
                        break;
                    }
                }

                if (!$skipClassToken) {
                    $class = true;
                }
            }

            if (\T_NAMESPACE === $token[0]) {
                $namespace = true;
            }
        }

        return false;
    }
}