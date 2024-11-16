<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Backend;

use Gedmo\Sluggable\Util\Urlizer;
use ProgramCms\DriveBundle\Setup\DriveManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class Image
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Backend
 */
class Image extends AbstractBackend
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var DriveManagerInterface
     */
    protected DriveManagerInterface $driveManager;

    /**
     * Image constructor.
     * @param DriveManagerInterface $driveManager
     * @param Url $url
     */
    public function __construct(
        DriveManagerInterface $driveManager,
        Url $url
    )
    {
        $this->url = $url;
        $this->driveManager = $driveManager;
    }

    /**
     * @param string $attributeCode
     * @param object $object
     */
    public function beforeSave(string $attributeCode, object $object)
    {
        $uploadedFile = $object->getData($attributeCode);
        if($uploadedFile instanceof UploadedFile) {
            $tableName = $object->getTableName();
            if ($uploadedFile->isValid()) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $destination = 'media/'. $tableName .'/' . $attributeCode;
                $this->driveManager->move($uploadedFile, $destination, $newFilename);
                // Replace config field value
                $publicFileName = $this->url->getBaseUrl() . '/media/' . $tableName . '/' . $attributeCode . '/' . $newFilename;
                $object->setData($attributeCode, $publicFileName);
            }
        }
    }
}