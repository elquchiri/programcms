<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

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

    protected function configure()
    {
        $this->setDescription('Compile and merge bundle SCSS and JS files into the app')
            ->setHelp('This command compiles and merges bundle SCSS and JS files into the app');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
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
                $this->_processJsControllers($bundlePath);
            }
        }

        // Destination file path
        $appScssPath = 'assets/styles/app.scss';

        // Clear existing contents of app.scss
        file_put_contents($appScssPath, '');

        // Load _extends files to override UI
        foreach ($this->extendsScssFiles as $scss) {
            file_put_contents($appScssPath, $scss, FILE_APPEND);
        }
        // Add Bootstrap
        file_put_contents($appScssPath, '@import "~bootstrap/scss/bootstrap";', FILE_APPEND);

        // Load _bundle files to UI
        foreach ($this->bundleScssFiles as $scss) {
            file_put_contents($appScssPath, $scss, FILE_APPEND);
        }

        // Run npm run dev command
        $output->writeln('Compiling styles using npm run dev...');
        $npmRunCommand = 'npm run dev';
        $output->writeln(shell_exec($npmRunCommand));
        $assetsInstallCommand = 'php bin/console assets:install';
        $output->writeln(shell_exec($assetsInstallCommand));

        $output->writeln('Styles compilation complete.');

        return Command::SUCCESS;
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateBundleScssFiles(string $bundlePath): void
    {
        $assetsFolder = $bundlePath . '/Resources/views/adminhtml/assets/css/source/';
        // Find _bundle.scss files
        $bundleScssFiles = glob($assetsFolder . '_bundle.scss');
        if(!empty($bundleScssFiles)) {
            $relativePath = $this->_getRelativePath($bundlePath);
            $importStatement = sprintf('@import "%s%s";', $relativePath, '/Resources/views/adminhtml/assets/css/source/_bundle.scss');
            $this->bundleScssFiles[] = $importStatement.PHP_EOL;
        }
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateExtendsScssFiles(string $bundlePath): void
    {
        $assetsFolder = $bundlePath . '/Resources/views/adminhtml/assets/css/source/';
        // Find _bundle.scss files
        $bundleScssFiles = glob($assetsFolder . '_extends.scss');
        if(!empty($bundleScssFiles)) {
            $relativePath = $this->_getRelativePath($bundlePath);
            $importStatement = sprintf('@import "%s%s";', $relativePath, '/Resources/views/adminhtml/assets/css/source/_extends.scss');
            $this->extendsScssFiles[] = $importStatement.PHP_EOL;
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
        return '../../' . ltrim(str_replace('\\', '/', $relativePath), '/');
    }

    /**
     * @param string $bundlePath
     */
    protected function _processJsControllers(string $bundlePath): void
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