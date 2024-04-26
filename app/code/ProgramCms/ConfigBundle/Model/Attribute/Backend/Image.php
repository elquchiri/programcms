<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Backend;

use Gedmo\Sluggable\Util\Urlizer;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Image
 * @package ProgramCms\ConfigBundle\Model\Attribute\Backend
 */
class Image extends AbstractBackend
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * Image constructor.
     * @param BundleManager $bundleManager
     */
    public function __construct(BundleManager $bundleManager)
    {
        $this->bundleManager = $bundleManager;
    }

    /**
     * @param $fieldData
     */
    public function beforeSave(&$fieldData)
    {
        $uploadedFile = $fieldData['value'];
        if($uploadedFile instanceof UploadedFile) {
            $rootDirectory = $this->bundleManager->getContainer()->getParameter('kernel.project_dir');

            if ($uploadedFile->isValid()) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $destination = $rootDirectory . '/public/media/core_config';
                $uploadedFile->move($destination, $newFilename);
                // Replace config field value
                $fieldData['value'] = $newFilename;
            }
        }
    }
}