<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

use Exception;
use ProgramCms\CoreBundle\View\Asset\Repository;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\AssetFile;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\File;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\ScssAssetFile;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\TemplateFile;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\PageLayoutFile;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\LayoutFile;

/**
 * Class FileSystem
 * @package ProgramCms\CoreBundle\View
 */
class FileSystem
{
    /**
     * @var Repository
     */
    protected Repository $assetRepository;

    /**
     * @var TemplateFile
     */
    protected TemplateFile $templateFile;

    /**
     * @var File
     */
    protected File $file;

    /**
     * @var PageLayoutFile
     */
    protected PageLayoutFile $pageLayoutFile;

    /**
     * @var LayoutFile
     */
    protected LayoutFile $layoutFile;

    /**
     * @var AssetFile
     */
    protected AssetFile $assetFile;

    /**
     * @var ScssAssetFile
     */
    protected ScssAssetFile $scssAssetFile;

    /**
     * FileSystem constructor.
     * @param Repository $assetRepository
     * @param File $file
     * @param TemplateFile $templateFile
     * @param PageLayoutFile $pageLayoutFile
     * @param LayoutFile $layoutFile
     * @param AssetFile $assetFile
     * @param ScssAssetFile $scssAssetFile
     */
    public function __construct(
        Repository $assetRepository,
        File $file,
        TemplateFile $templateFile,
        PageLayoutFile $pageLayoutFile,
        LayoutFile $layoutFile,
        AssetFile $assetFile,
        ScssAssetFile $scssAssetFile
    )
    {
        $this->assetRepository = $assetRepository;
        $this->templateFile = $templateFile;
        $this->file = $file;
        $this->pageLayoutFile = $pageLayoutFile;
        $this->layoutFile = $layoutFile;
        $this->assetFile = $assetFile;
        $this->scssAssetFile = $scssAssetFile;
    }

    /**
     * @param $fileId
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function getFilename($fileId, array $params = [])
    {
        list($bundle, $filePath) = Repository::extractBundle($fileId);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->file->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }

    /**
     * @param $template
     * @param $params
     * @return mixed|void
     * @throws Exception
     */
    public function getTemplateFileName($template, $params)
    {
        list($bundle, $filePath) = Repository::extractBundle($template);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->templateFile->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }

    /**
     * @param $pageLayout
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function getPageLayoutFileName($pageLayout, $params)
    {
        list($bundle, $filePath) = Repository::extractBundle($pageLayout);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->pageLayoutFile->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }

    /**
     * @param $template
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function getLayoutFileName($layout, $params)
    {
        list($bundle, $filePath) = Repository::extractBundle($layout);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->layoutFile->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }

    /**
     * @param $asset
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function getAssetFileName($asset, $params)
    {
        list($bundle, $filePath) = Repository::extractBundle($asset);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->assetFile->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }

    /**
     * @param $asset
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function getScssAssetFileName($asset, $params)
    {
        list($bundle, $filePath) = Repository::extractBundle($asset);
        if ($bundle) {
            $params['bundle'] = $bundle;
        }
        $this->assetRepository->updateDesignParams($params);

        return $this->scssAssetFile->getFile(
            $params['area'],
            $params['themeModel'],
            $filePath,
            $params['bundle']
        );
    }
}