<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Command;

use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GenerateStaticsCommand
 * @package ProgramCms\UiBundle\Command
 */
#[AsCommand(
    name: 'assets:compile',
    aliases: ['ass:com'],
    hidden: false
)]
class GenerateStaticsCommand extends Command
{
    /**
     * @var array
     */
    protected array $bundleScssFiles = [];
    /**
     * @var array
     */
    protected array $extendsScssFiles = [];

    const AREAS = ['adminhtml', 'frontend'];

    protected function configure()
    {
        $this->setDescription('Compile and merge bundle SCSS and JS files in the app')
            ->setHelp('This command compiles and merges bundle SCSS and JS files into the app');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Create Website Views structure folders


        // Get all bundles
        $bundles = $this->getApplication()->getKernel()->getBundles();

        // Loop through bundles
        foreach ($bundles as $bundle) {
            $reflectedBundle = new \ReflectionClass(get_class($bundle));
            if($reflectedBundle->hasMethod('isProgramCmsBundle')) {
                $bundlePath = $bundle->getPath();
                /**
                 * Locate _bundle.scss entry files
                 * Merge entry points into main app
                 */
                $this->_populateBundleScssFiles($bundlePath);
                $this->_populateExtendsScssFiles($bundlePath);
                /**
                 * Get all JavaScript files in the source directory
                 * Copy the content of each JavaScript file to the destination directory
                 */
                //$this->_processJsFiles($bundlePath);
            }
        }

        // Destination file path
        $appScssPaths = [
            'frontend' => 'assets/frontend/ProgramCms/Blank/en_US/app.scss',
            'adminhtml' => 'assets/adminhtml/ProgramCms/Backend/ar_MA/app.scss'
        ];
        foreach($appScssPaths as $area => $appScssPath) {
            // Clear existing contents of app.scss
            file_put_contents($appScssPath, '');

            // Load _extends files to override UI
            if(isset($this->extendsScssFiles[$area])) {
                foreach ($this->extendsScssFiles[$area] as $scss) {
                    file_put_contents($appScssPath, $scss, FILE_APPEND);
                }
            }
            // Add Bootstrap
            file_put_contents($appScssPath, '@import "~bootstrap/scss/bootstrap";', FILE_APPEND);

            // Load _bundle files to UI
            if(isset($this->bundleScssFiles[$area])) {
                foreach ($this->bundleScssFiles[$area] as $scss) {
                    file_put_contents($appScssPath, $scss, FILE_APPEND);
                }
            }
        }

        // Run npm run dev command
        $output->writeln('Compiling styles using npm run dev...');
        $npmRunCommand = 'npm run dev';
        $output->writeln(shell_exec($npmRunCommand));
        $assetsInstallCommand = 'php bin/pcms assets:install';
        $output->writeln(shell_exec($assetsInstallCommand));

        $output->writeln('Assets compilation complete successfully.');

        return Command::SUCCESS;
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateBundleScssFiles(string $bundlePath): void
    {
        foreach(self::AREAS as $area) {
            $assetsFolder = $bundlePath . "/Resources/views/{$area}/assets/css/source/";
            // Find _bundle.scss files
            $bundleScssFiles = glob($assetsFolder . '_bundle.scss');
            if (!empty($bundleScssFiles)) {
                $relativePath = $this->_getRelativePath($bundlePath);
                $importStatement = sprintf('@import "%s%s";', $relativePath, "/Resources/views/{$area}/assets/css/source/_bundle.scss");
                $this->bundleScssFiles[$area][] = $importStatement . PHP_EOL;
            }
        }
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateExtendsScssFiles(string $bundlePath): void
    {
        foreach(self::AREAS as $area) {
            $assetsFolder = $bundlePath . "/Resources/views/{$area}/assets/css/source/";
            // Find _extends.scss files
            $bundleScssFiles = glob($assetsFolder . '_extends.scss');
            if (!empty($bundleScssFiles)) {
                $relativePath = $this->_getRelativePath($bundlePath);
                $importStatement = sprintf('@import "%s%s";', $relativePath, "/Resources/views/{$area}/assets/css/source/_extends.scss");
                $this->extendsScssFiles[$area][] = $importStatement . PHP_EOL;
            }
        }
    }

    /**
     * @param string $bundlePath
     * @return string
     */
    protected function _getRelativePath(string $bundlePath): string
    {
        $projectPath = $this->getApplication()->getKernel()->getProjectDir();
        // Calculate the relative path
        $relativePath = str_replace($projectPath, '', $bundlePath);
        // Remove the leading slash if present
        return '../../../../../' . ltrim(str_replace('\\', '/', $relativePath), '/');
    }

    /**
     * @param string $bundlePath
     */
    protected function _processJsFiles(string $bundlePath): void
    {
        $controllersFolderPath = 'assets/controllers';
        $assetsFolder = $bundlePath . '/Resources/views/adminhtml/assets/';
        $jsFiles = glob($assetsFolder . 'js/controllers/*.js');
        $fileSystem = new \Symfony\Component\Filesystem\Filesystem();
        foreach ($jsFiles as $file) {
            $filename = basename($file);
            $destinationFile = $controllersFolderPath . '/' . $filename;
            // Copy the file content
            $content = file_get_contents($file);
            $fileSystem->dumpFile($destinationFile, $content);
        }
    }
}