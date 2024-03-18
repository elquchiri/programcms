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
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\File;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\TemplateFile;

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
     * FileSystem constructor.
     * @param Repository $assetRepository
     * @param File $file
     * @param TemplateFile $templateFile
     */
    public function __construct(
        Repository $assetRepository,
        File $file,
        TemplateFile $templateFile
    )
    {
        $this->assetRepository = $assetRepository;
        $this->templateFile = $templateFile;
        $this->file = $file;
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
}