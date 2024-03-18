<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Template\File;

use Exception;
use ProgramCms\CoreBundle\Serialize\Serializer\Json;
use ProgramCms\CoreBundle\View\FileSystem;

/**
 * Class Resolver
 * @package ProgramCms\CoreBundle\View\Element\Template\File
 */
class Resolver
{
    /**
     * @var Json
     */
    protected Json $json;

    /**
     * @var FileSystem
     */
    protected FileSystem $fileSystem;

    /**
     * @var array
     */
    private array $templateFilesMap = [];

    /**
     * Resolver constructor.
     * @param Json $json
     * @param FileSystem $fileSystem
     */
    public function __construct(
        Json $json,
        FileSystem $fileSystem
    )
    {
        $this->json = $json;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param $template
     * @param $params
     * @return mixed|void
     * @throws Exception
     */
    public function getTemplateFileName($template, $params)
    {
        $key = $template . '_' . $this->json->serialize($params);
        if (!isset($this->_templateFilesMap[$key])) {
            $this->templateFilesMap[$key] = $this->fileSystem->getTemplateFileName($template, $params);
        }
        return $this->templateFilesMap[$key];
    }
}