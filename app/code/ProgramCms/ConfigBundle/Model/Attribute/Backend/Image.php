<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Backend;

use Gedmo\Sluggable\Util\Urlizer;
use ProgramCms\DriveBundle\Setup\DriveManagerInterface;
use ProgramCms\RouterBundle\Service\UrlInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Image
 * @package ProgramCms\ConfigBundle\Model\Attribute\Backend
 */
class Image extends AbstractBackend
{
    /**
     * @var DriveManagerInterface
     */
    protected DriveManagerInterface $driveManager;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * Image constructor.
     * @param DriveManagerInterface $driveManager
     * @param UrlInterface $url
     */
    public function __construct(
        DriveManagerInterface $driveManager,
        UrlInterface $url
    )
    {
        $this->driveManager = $driveManager;
        $this->url = $url;
    }

    /**
     * @param $fieldData
     */
    public function beforeSave(&$fieldData)
    {
        $uploadedFile = $fieldData['value'];
        if($uploadedFile instanceof UploadedFile) {
            if ($uploadedFile->isValid()) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $destination = 'media/core_config';
                // Use DriverManager to upload Image
                $this->driveManager->move($uploadedFile, $destination, $newFilename);
                $publicFileName = $this->url->getBaseUrl() . '/' . $destination . '/' . $newFilename;
                // Replace config field value
                $fieldData['value'] = $publicFileName;
            }
        }
    }
}