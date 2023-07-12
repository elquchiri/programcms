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
    name: 'generate:statics',
    aliases: ['gen:st'],
    hidden: false
)]
class GenerateStaticsCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Compile and merge bundle SCSS files into app.scss')
            ->setHelp('This command compiles and merges bundle SCSS files into the app.scss file');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        // Get all bundles
        $bundles = $this->getApplication()->getKernel()->getBundles();

        // Destination file path
        $appScssPath = 'assets/styles/app.scss';

        // Clear existing contents of app.scss
        file_put_contents($appScssPath, '');
        file_put_contents($appScssPath, "@import '~bootstrap/scss/bootstrap';");

        // Loop through bundles
        foreach ($bundles as $bundle) {
            $reflectedBundle = new \ReflectionClass(get_class($bundle));
            if($reflectedBundle->hasMethod('isProgramCmsBundle')) {
                // Bundle resources directory
                $bundleResourcesDir = $bundle->getPath() . '/Resources/views/adminhtml/assets/css/source/';
                $bundleName = $bundle->getName();
                $bundle = $this->getApplication()->getKernel()->getBundle($bundleName);
                $bundlePath = $bundle->getPath();

                // Get the project root path
                $projectPath = $this->getApplication()->getKernel()->getProjectDir();

                // Calculate the relative path
                $relativePath = str_replace($projectPath, '', $bundlePath);

                // Remove the leading slash if present
                $relativePath = '../../' . ltrim(str_replace('\\', '/', $relativePath), '/');

                // Find _bundle.scss files
                $bundleScssFiles = glob($bundleResourcesDir . '_bundle.scss');
                // Merge SCSS files into app.scss
                foreach ($bundleScssFiles as $scssFile) {
                    $importStatement = sprintf('@import "%s%s";', $relativePath, '/Resources/views/adminhtml/assets/css/source/_bundle.scss');
                    file_put_contents($appScssPath, $importStatement.PHP_EOL, FILE_APPEND);
                }
            }
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
}