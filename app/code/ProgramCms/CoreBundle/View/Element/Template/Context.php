<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Template;

use ProgramCms\CoreBundle\App\State;
use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use ProgramCms\CoreBundle\Helper\Language;
use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\Element\Template\File\Resolver;
use ProgramCms\CoreBundle\View\FileSystem;
use ProgramCms\CoreBundle\View\Layout;
use ProgramCms\CoreBundle\View\Page\Config;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\ThemeBundle\Loader\LayoutLoader;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;
use ProgramCms\ThemeBundle\Webpack\Output as WebpackOutput;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Twig\Environment;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\View\Element\Template
 */
class Context extends \ProgramCms\CoreBundle\View\Element\Context
{
    /**
     * @var Environment
     */
    protected Environment $environment;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var Config
     */
    protected Config $pageConfig;

    /**
     * @var Layout
     */
    protected Layout $layout;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var LocaleSwitcher
     */
    protected LocaleSwitcher $localeSwitcher;

    /**
     * @var Language
     */
    protected Language $language;

    /**
     * @var WebpackOutput
     */
    protected WebpackOutput $webpackOutput;

    /**
     * @var State
     */
    protected State $state;

    /**
     * @var Resolver
     */
    protected Resolver $resolver;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var FileSystem
     */
    protected FileSystem $fileSystem;

    /**
     * @var FilesystemAdapter
     */
    protected FilesystemAdapter $filesystemAdapter;

    /**
     * @var LayoutLoader
     */
    protected LayoutLoader $layoutLoader;

    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

    /**
     * Context constructor.
     * @param BundleManager $bundleManager
     * @param DirectoryList $directoryList
     * @param Request $request
     * @param Environment $environment
     * @param Url $url
     * @param Config $pageConfig
     * @param Layout $layout
     * @param TranslatorInterface $translator
     * @param LocaleSwitcher $localeSwitcher
     * @param Language $language
     * @param WebpackOutput $webpackOutput
     * @param State $state
     * @param Resolver $resolver
     * @param FileSystem $fileSystem
     * @param LayoutLoader $layoutLoader
     * @param TransformerInterface $transformer
     */
    public function __construct(
        BundleManager $bundleManager,
        DirectoryList $directoryList,
        Request $request,
        Environment $environment,
        Url $url,
        Config $pageConfig,
        Layout $layout,
        TranslatorInterface $translator,
        LocaleSwitcher $localeSwitcher,
        Language $language,
        WebpackOutput $webpackOutput,
        State $state,
        Resolver $resolver,
        FileSystem $fileSystem,
        LayoutLoader $layoutLoader,
        TransformerInterface $transformer
    )
    {
        parent::__construct($directoryList, $request);
        $this->environment = $environment;
        $this->url = $url;
        $this->pageConfig = $pageConfig;
        $this->layout = $layout;
        $this->translator = $translator;
        $this->localeSwitcher = $localeSwitcher;
        $this->language = $language;
        $this->webpackOutput = $webpackOutput;
        $this->state = $state;
        $this->resolver = $resolver;
        $this->bundleManager = $bundleManager;
        $this->fileSystem = $fileSystem;
        $this->filesystemAdapter = new FilesystemAdapter();
        $this->layoutLoader = $layoutLoader;
        $this->transformer = $transformer;
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Config
     */
    public function getPageConfig(): Config
    {
        return $this->pageConfig;
    }

    /**
     * @return Layout
     */
    public function getLayout(): Layout
    {
        return $this->layout;
    }

    /**
     * Get Translator
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * @return LocaleSwitcher
     */
    public function getLocaleSwitcher(): LocaleSwitcher
    {
        return $this->localeSwitcher;
    }

    /**
     * @return Language
     */
    public function getLanguageHelper(): Language
    {
        return $this->language;
    }

    /**
     * @return WebpackOutput
     */
    public function getWebpackOutput(): WebpackOutput
    {
        return $this->webpackOutput;
    }

    /**
     * @return State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return Resolver
     */
    public function getResolver(): Resolver
    {
        return $this->resolver;
    }

    /**
     * @return BundleManager
     */
    public function getBundleManager(): BundleManager
    {
        return $this->bundleManager;
    }

    /**
     * @return FileSystem
     */
    public function getFileSystem(): FileSystem
    {
        return $this->fileSystem;
    }

    /**
     * @return FilesystemAdapter
     */
    public function getFileSystemAdapter(): FilesystemAdapter
    {
        return $this->filesystemAdapter;
    }

    /**
     * @return LayoutLoader
     */
    public function getLayoutLoader(): LayoutLoader
    {
        return $this->layoutLoader;
    }

    /**
     * @return TransformerInterface
     */
    public function getTransformer(): TransformerInterface
    {
        return $this->transformer;
    }
}