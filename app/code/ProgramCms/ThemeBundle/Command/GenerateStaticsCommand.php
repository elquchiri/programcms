<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Command;

use ProgramCms\ConfigBundle\App\Config;
use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class GenerateStaticsCommand
 * @package ProgramCms\ThemeBundle\Command
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

    /**
     * @var array
     */
    protected array $jsFiles = [];

    const AREAS = ['adminhtml', 'frontend'];

    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * GenerateStaticsCommand constructor.
     * @param ThemeRepository $themeRepository
     * @param WebsiteViewRepository $websiteViewRepository
     * @param Config $config
     * @param Filesystem $filesystem
     * @param DirectoryList $directoryList
     * @param BundleManager $bundleManager
     * @param string|null $name
     */
    public function __construct(
        ThemeRepository $themeRepository,
        WebsiteViewRepository $websiteViewRepository,
        Config $config,
        Filesystem $filesystem,
        DirectoryList $directoryList,
        BundleManager $bundleManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->websiteViewRepository = $websiteViewRepository;
        $this->themeRepository = $themeRepository;
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->directoryList = $directoryList;
        $this->bundleManager = $bundleManager;
    }

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
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();

        // Loop through bundles
        foreach ($bundles as $bundle) {
            $bundlePath = $bundle['path'];

            // Locate _bundle.scss entry files
            // Merge entry points into main app
            $this->_populateBundleScssFiles($bundlePath);
            $this->_populateExtendsScssFiles($bundlePath);

            // Get all JavaScript files in the source directory
            // Copy the content of each JavaScript file to the destination directory
            $this->_populateJsFiles($bundlePath);
        }

        // Generate Webpack JS
        $this->generateWebpackConfig();

        // Run npm run dev command
        $output->writeln('Compiling styles using npm run dev...');
        $npmRunCommand = 'webpack --mode production';
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
        foreach (self::AREAS as $area) {
            $assetsFolder = $bundlePath . "/Resources/views/{$area}/assets/css/source/";
            // Find _bundle.scss files
            $bundleScssFiles = glob($assetsFolder . '_bundle.scss');
            if (!empty($bundleScssFiles)) {
                $relativePath = $this->_getRelativePath($bundlePath);
                $importStatement = sprintf("'./%s%s'", $relativePath, "/Resources/views/{$area}/assets/css/source/_bundle.scss");
                $this->bundleScssFiles[$area][] = $importStatement;
            }
        }
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateExtendsScssFiles(string $bundlePath): void
    {
        foreach (self::AREAS as $area) {
            $assetsFolder = $bundlePath . "/Resources/views/{$area}/assets/css/source/";
            // Find _extends.scss files
            $bundleScssFiles = glob($assetsFolder . '_extends.scss');
            if (!empty($bundleScssFiles)) {
                $relativePath = $this->_getRelativePath($bundlePath);
                $importStatement = sprintf("'./%s%s'", $relativePath, "/Resources/views/{$area}/assets/css/source/_extends.scss");
                $this->extendsScssFiles[$area][] = $importStatement;
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
        return ltrim(str_replace('\\', '/', $relativePath), '/');
    }

    /**
     * @param string $bundlePath
     */
    protected function _populateJsFiles(string $bundlePath): void
    {
        $relativePath = $this->_getRelativePath($bundlePath);

        foreach (self::AREAS as $area) {
            $jsAssetsFolder = $relativePath . "/Resources/views/{$area}/assets/js/controllers/";
            if ($this->filesystem->exists($jsAssetsFolder)) {
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($jsAssetsFolder)
                );

                // Iterate through each file found by the iterator
                foreach ($iterator as $file) {
                    // Check if the file is a JavaScript file
                    if ($file->isFile() && $file->getExtension() === 'js') {
                        // Get the relative path of the file inside the assets folder
                        $this->jsFiles[$area][] = sprintf("'./%s%s'", $jsAssetsFolder, $file->getFilename());
                    }
                }
            }
        }
    }

    /**
     * Build and Generate Webpack Config file
     */
    private function generateWebpackConfig()
    {
        $webpackFile = $this->directoryList->getRoot() . DIRECTORY_SEPARATOR . 'webpack.config.js';

        $webpackConfig = <<<JS
            const path = require('path');
            const webpack = require('webpack');
            const miniCssExtractPlugin = require('mini-css-extract-plugin');
            const RtlCssPlugin = require('rtlcss-plugin');
            JS;

        $configArray = [];

        foreach ($this->themeRepository->findAll() as $theme) {
            foreach ($this->websiteViewRepository->findAll() as $websiteView) {
                // Check whether area data coming from theme table is valid area
                if (!in_array($theme->getArea(), self::AREAS)) {
                    throw new \InvalidArgumentException("Invalid area " . $theme->getArea());
                }

                $configArray[] = $this->prepareWebpackConfig(
                    $theme->getArea(),
                    $theme->getThemePath(),
                    $websiteView->getWebsiteViewCode()
                );
            }
        }

        $webpackConfig .= "module.exports = [" . implode(",", $configArray) . "]";
        $webpackConfig = rtrim(preg_replace('/ {2,}|\n/', ' ', $webpackConfig));
        $this->filesystem->dumpFile(
            $webpackFile,
            $webpackConfig
        );
    }

    /**
     * @param $area
     * @param $themePath
     * @param $websiteView
     * @return string
     */
    private function prepareWebpackConfig($area, $themePath, $websiteView): string
    {
        $extendsFiles = $this->extendsScssFiles[$area] ?? [];
        $bundleScssFiles = $this->bundleScssFiles[$area] ?? [];
        $jsFiles = $this->jsFiles[$area] ?? [];
        $entryFiles = implode(',', array_merge(
            $extendsFiles,
            ["'./app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/js/app.js'"],
            $bundleScssFiles,
            $jsFiles
        ));
        $webpackConfig = <<<JS
            {
                entry: {
                    app: [
                        {$entryFiles}
                    ]
                },
                output: {
                    path: path.resolve(__dirname, 'public/build/{$area}/{$themePath}/{$websiteView}'),
                    filename: '[name].js',
                    publicPath: '/build/{$area}/{$themePath}/{$websiteView}/',
                },
                module: {
                    rules: [
                        {
                            test: /\.scss$/,
                            use: [
                                miniCssExtractPlugin.loader,
                                'css-loader',
                                'sass-loader',
                                'postcss-loader'
                            ],
                        },
                    ],
                },
                plugins: [
                    new webpack.ProvidePlugin({
                        $: 'jquery',
                        jQuery: 'jquery',
                    }),
                    new miniCssExtractPlugin({
                        filename: '[name].css'
                    }),
                    new RtlCssPlugin({
                        filename: 'app.css'
                    })
                ],
                performance: {
                  hints: false,
                  maxEntrypointSize: 512000,
                  maxAssetSize: 512000
                },
            }
JS;
        return $webpackConfig;
    }
}