<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Backend;

use Gedmo\Sluggable\Util\Urlizer;
use \ProgramCms\CoreBundle\Model\Utils\BundleManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Image
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Backend
 */
class Image extends AbstractBackend
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Image constructor.
     * @param BundleManager $bundleManager
     * @param Url $url
     */
    public function __construct(
        BundleManager $bundleManager,
        Url $url
    )
    {
        $this->bundleManager = $bundleManager;
        $this->url = $url;
    }

    /**
     * @param string $attributeCode
     * @param object $object
     */
    public function beforeSave(string $attributeCode, object $object)
    {
        $uploadedFile = $object->getData($attributeCode);
        if($uploadedFile instanceof UploadedFile) {
            $rootDirectory = $this->bundleManager->getContainer()->getParameter('kernel.project_dir');
            $tableName = $object->getTableName();
            if ($uploadedFile->isValid()) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $destination = $rootDirectory . '/public/media/'. $tableName .'/' . $attributeCode;
                $uploadedFile->move($destination, $newFilename);
                // Replace config field value
                $publicFileName = $this->url->getBaseUrl() . '/media/' . $tableName . '/' . $attributeCode . '/' . $newFilename;
                $object->setData($attributeCode, $publicFileName);
            }
        }
    }
}