<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Controller\Ajax;

use ProgramCms\CoreBundle\Controller\Controller;
use Gedmo\Sluggable\Util\Urlizer;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\DriveBundle\Entity\DriveFile;
use ProgramCms\DriveBundle\Helper\Data;
use ProgramCms\DriveBundle\Helper\FileHelper;
use ProgramCms\DriveBundle\Repository\DriveFileRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UploadController
 * @package ProgramCms\DriveBundle\Controller\Ajax
 */
class UploadController extends Controller
{
    /**
     * @var DriveFileRepository
     */
    protected DriveFileRepository $driveFileRepository;

    /**
     * @var FileHelper
     */
    protected FileHelper $fileHelper;

    /**
     * FileController constructor.
     * @param Context $context
     * @param DriveFileRepository $driveFileRepository
     * @param FileHelper $fileHelper
     */
    public function __construct(
        Context $context,
        DriveFileRepository $driveFileRepository,
        FileHelper $fileHelper
    )
    {
        parent::__construct($context);
        $this->driveFileRepository = $driveFileRepository;
        $this->fileHelper = $fileHelper;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $rootDirectory = $this->getParameter('kernel.project_dir');
        $files = $this->getRequest()->getCurrentRequest()->files->get('files');
        $response = ['data' => []];
        /** @var UploadedFile $file */
        foreach($files as $file) {
            if ($file->isValid()) {
                $fileSize = $file->getSize();
                $fileType = $file->getType();
                $mimeType = $file->getClientMimeType();
                $extension = $file->getClientOriginalExtension();
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename) . '-' . uniqid() . '.' . $file->guessExtension();
                $destination = $rootDirectory . '/public/' . Data::DRIVE_LOCATION;
                $perms = $this->fileHelper->permsToArray($file->getPerms());
                try {
                    $file->move($destination, $newFilename);
                    $publicFileName = $this->url->getBaseUrl() . '/' . Data::DRIVE_LOCATION . '/' . $newFilename;
                    // Save File on DB
                    $driveFile = new DriveFile();
                    $driveFile
                        ->setName($originalFilename . '.' . $extension)
                        ->setPath($publicFileName)
                        ->setGeneratedName($newFilename)
                        ->setSize($fileSize)
                        ->setExtension($extension)
                        ->setType($fileType)
                        ->setMimeType($mimeType)
                        ->setPerms($perms)
                        ->updateTimestamps();
                    $this->driveFileRepository->save($driveFile);

                    $response['data'][] = [
                        'type' =>'image',
                        'src' => $driveFile->getPath(),
                        'height' => 100,
                        'width' => 200
                    ];
                } catch (FileException $e) {
                    $response['data'] = [];
                }
            }
        }

        return $this->json($response);
    }
}