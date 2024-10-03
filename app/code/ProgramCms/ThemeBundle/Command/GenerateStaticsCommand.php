<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Command;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\Helper\Language;
use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\ThemeBundle\Entity\Theme;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ProgramCms\ThemeBundle\Webpack\Generator\Entry;
use ProgramCms\ThemeBundle\Webpack\Generator\Module;
use ProgramCms\ThemeBundle\Webpack\Generator\Output;
use ProgramCms\ThemeBundle\Webpack\Generator\Performance;
use ProgramCms\ThemeBundle\Webpack\Generator\Plugins;
use ProgramCms\ThemeBundle\Webpack\Generator\WebpackConfig;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use ProgramCms\CoreBundle\View\FileSystem as ViewFileSystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use Exception;

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
    const LOCALE_CONFIG = 'general/locale_options/locale';

    const WEBPACK_CONFIG_FILE = 'webpack.config.js';

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
     * @var Language
     */
    protected Language $language;

    /**
     * @var ViewFileSystem
     */
    protected ViewFileSystem $viewFileSystem;

    /**
     * GenerateStaticsCommand constructor.
     * @param ThemeRepository $themeRepository
     * @param WebsiteViewRepository $websiteViewRepository
     * @param Config $config
     * @param Filesystem $filesystem
     * @param DirectoryList $directoryList
     * @param BundleManager $bundleManager
     * @param Language $language
     * @param ViewFileSystem $viewFileSystem
     * @param string|null $name
     */
    public function __construct(
        ThemeRepository $themeRepository,
        WebsiteViewRepository $websiteViewRepository,
        Config $config,
        Filesystem $filesystem,
        DirectoryList $directoryList,
        BundleManager $bundleManager,
        Language $language,
        ViewFileSystem $viewFileSystem,
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
        $this->language = $language;
        $this->viewFileSystem = $viewFileSystem;
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

        foreach ($this->themeRepository->findAll() as $theme) {
            // Loop through bundles
            foreach ($bundles as $bundle) {
                $bundleName = $bundle['name'];

                // Locate _bundle.scss entry files
                // Merge entry points into main app
                $this->populateBundleScssFiles($bundleName, $theme);
                $this->populateExtendsScssFiles($bundleName, $theme);

                // Get all JavaScript files in the source directory
                // Copy the content of each JavaScript file to the destination directory
                $this->populateJsFiles($bundleName, $theme);
            }
        }

        // Generate Webpack JS
        $this->generateWebpackConfig();

        // Run npm run dev command
        $output->writeln('Compiling styles using npm run build ...');
        $npmRunCommand = 'npm run build';
        $output->writeln(shell_exec($npmRunCommand));
        $assetsInstallCommand = 'php bin/pcms assets:install';
        $output->writeln(shell_exec($assetsInstallCommand));

        $output->writeln('Assets compilation complete successfully.');
        return Command::SUCCESS;
    }

    /**
     * Gets _bundle.scss from theme first else from bundle
     * used to override bundle core scss logic
     * @param string $bundleName
     * @param Theme $theme
     * @throws Exception
     */
    protected function populateBundleScssFiles(string $bundleName, Theme $theme): void
    {
        $themeId = $theme->getThemeId();
        $area = $theme->getArea();
        $params = ['bundle' => $bundleName];
        if ($area) {
            $params['area'] = $area;
        }
        if ($themeId) {
            $params['theme'] = $themeId;
        }

        $scssFile = $this->viewFileSystem->getScssAssetFileName('_bundle.scss', $params);
        if (!empty($scssFile)) {
            $relativePath = $this->_getRelativePath($scssFile);
            $importStatement = sprintf("'./%s'", $relativePath);
            $this->bundleScssFiles[$area][md5($relativePath)] = $importStatement;
        }
    }

    /**
     * Get and combine all _extends scss files
     * @param string $bundleName
     * @param Theme $theme
     * @throws Exception
     */
    protected function populateExtendsScssFiles(string $bundleName, Theme $theme): void
    {
        $themeId = $theme->getThemeId();
        $area = $theme->getArea();
        $params = ['bundle' => $bundleName];
        if ($area) {
            $params['area'] = $area;
        }
        if ($themeId) {
            $params['theme'] = $themeId;
        }
        $assets = $this->viewFileSystem->getAssetFileName('css/source/_extends.scss', $params);
        if (!empty($assets)) {
            foreach ($assets as $asset) {
                $scssFile = glob($asset);
                if (!empty($scssFile)) {
                    $relativePath = $this->_getRelativePath($scssFile[0]);
                    $importStatement = sprintf("'./%s'", $relativePath);
                    $this->extendsScssFiles[$area][md5($relativePath)] = $importStatement;
                }
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
     * @param string $bundleName
     * @param Theme $theme
     * @throws Exception
     */
    protected function populateJsFiles(string $bundleName, Theme $theme): void
    {
        $themeId = $theme->getThemeId();
        $area = $theme->getArea();
        $params = ['bundle' => $bundleName];
        if ($area) {
            $params['area'] = $area;
        }
        if ($themeId) {
            $params['theme'] = $themeId;
        }
        $assets = $this->viewFileSystem->getAssetFileName('js/controllers/', $params);
        if (!empty($assets)) {
            foreach ($assets as $asset) {
                if ($this->filesystem->exists($asset)) {
                    $iterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($asset)
                    );

                    // Iterate through each file found by the iterator
                    foreach ($iterator as $file) {
                        // Check if the file is a JavaScript file
                        if ($file->isFile() && $file->getExtension() === 'js') {
                            $relativePath = $this->_getRelativePath($asset) . $file->getFilename();
                            // Get the relative path of the file inside the assets folder
                            $this->jsFiles[$area][md5($relativePath)] = sprintf("'./%s'", $relativePath);
                        }
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
        $webpackFile = $this->getWebpackConfigFile();
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
                    $websiteView
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
     * @return string
     */
    private function getWebpackConfigFile(): string
    {
        return $this->directoryList->getRoot() . DIRECTORY_SEPARATOR . self::WEBPACK_CONFIG_FILE;
    }

    /**
     * @param $area
     * @param $themePath
     * @param WebsiteView $websiteView
     * @return string
     */
    private function prepareWebpackConfig($area, $themePath, WebsiteView $websiteView): string
    {
        $locale = $this->getLocaleByWebsiteView($websiteView->getWebsiteViewId());
        $isRtl = $this->language->isRtl($locale);
        $extendsFiles = $this->extendsScssFiles[$area] ?? [];
        $bundleScssFiles = $this->bundleScssFiles[$area] ?? [];
        $jsFiles = $this->jsFiles[$area] ?? [];
        $entryFiles = array_merge(
            $bundleScssFiles,
            $extendsFiles,
            ["'./app/code/ProgramCms/ThemeBundle/Resources/views/adminhtml/assets/js/app.js'"],
            $jsFiles
        );

        $plugins = new Plugins([
            new Plugins\Plugin('webpack.ProvidePlugin', [
                '$' => 'jquery',
                'jquery' => 'jquery'
            ]),
            new Plugins\Plugin('miniCssExtractPlugin', [
                'filename' => '[name].css'
            ])
        ]);

        if ($isRtl) {
            $plugins->addPlugin(
                new Plugins\Plugin('RtlCssPlugin', [
                    'filename' => 'app.css'
                ])
            );
        }

        $webpackConfig = new WebpackConfig([
            new Entry([
                'app' => $entryFiles
            ]),
            new Output(
                "public/build/{$area}/{$themePath}/{$locale}",
                '[name].js',
                "/build/{$area}/{$themePath}/{$locale}/"
            ),
            new Module([
                new Module\Rules([
                    new Module\Rule(
                        '/\.scss$/',
                        [
                            ['loader' => 'miniCssExtractPlugin.loader', 'mode' => Module\Rule::JS_MODE],
                            ['loader' => 'css-loader', 'mode' => Module\Rule::STRING_MODE],
                            ['loader' => 'sass-loader', 'mode' => Module\Rule::STRING_MODE],
                            ['loader' => 'postcss-loader', 'mode' => Module\Rule::STRING_MODE],
                        ]
                    )
                ])
            ]),
            $plugins,
            new Performance(false, 512000, 512000)
        ]);

        return $webpackConfig->output();
    }

    /**
     * @param int $websiteViewId
     * @return string
     */
    public function getLocaleByWebsiteView(int $websiteViewId): string
    {
        return $this->config->getValue(
            self::LOCALE_CONFIG,
            'website_view',
            $websiteViewId
        );
    }
}