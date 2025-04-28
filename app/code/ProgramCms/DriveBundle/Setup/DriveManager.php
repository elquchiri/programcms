<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Setup;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Model\Utils\BundleManagerInterface;
use ProgramCms\DriveBundle\Entity\DriveFile;
use ProgramCms\DriveBundle\Helper\FileHelper;
use ProgramCms\DriveBundle\Repository\DriveFileRepository;
use ProgramCms\RouterBundle\Service\UrlInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class DriveManager
 * @package ProgramCms\DriveBundle\Setup
 */
class DriveManager implements DriveManagerInterface
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
     * @var BundleManagerInterface
     */
    protected BundleManagerInterface $bundleManager;

    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;
    protected EntityManagerInterface $entityManager;

    /**
     * DriveManager constructor.
     * @param BundleManagerInterface $bundleManager
     * @param DriveFileRepository $driveFileRepository
     * @param FileHelper $fileHelper
     * @param UrlInterface $url
     */
    public function __construct(
        BundleManagerInterface $bundleManager,
        DriveFileRepository $driveFileRepository,
        FileHelper $fileHelper,
        UrlInterface $url,
        EntityManagerInterface $entityManager
    )
    {
        $this->driveFileRepository = $driveFileRepository;
        $this->fileHelper = $fileHelper;
        $this->bundleManager = $bundleManager;
        $this->url = $url;
        $this->entityManager = $entityManager;
    }

    /**
     * @param UploadedFile $file
     * @param string $destination
     * @param string $newFilename
     * @return void
     */
    public function move(UploadedFile $file, string $destination, string $newFilename)
    {
        $rootDir = $this->bundleManager->getContainer()->getParameter('kernel.project_dir');
        $publicDir = $rootDir . '/public/';
        $fileSize = $file->getSize();
        $fileExt = $file->getClientOriginalExtension();
        $fileType = $file->getType();
        $mimeType = $file->getClientMimeType();
        $perms = $this->fileHelper->permsToArray($file->getPerms());
        $driveFilePath = $this->url->getBaseUrl() . '/' . $destination . '/' . $newFilename;

        $file->move($publicDir . $destination, $newFilename);

        $driveFile = new DriveFile();
        $driveFile
            ->setName($file->getClientOriginalName())
            ->setSize($fileSize)
            ->setExtension($fileExt)
            ->setPath($driveFilePath)
            ->setGeneratedName($newFilename)
            ->setType($fileType)
            ->setMimeType($mimeType)
            ->setPerms($perms)
            ->updateTimestamps();

        /**
         * The onFlush event fires while Doctrine is preparing to sync with the database.
         * If you do a $this->driveFileRepository->save($driveFile)
         * (which probably does a persist + flush) inside onFlush,
         * you break Doctrine's lifecycle.
         */
        $this->driveFileRepository->save($driveFile, false);
        $this->entityManager->getUnitOfWork()->computeChangeSet(
            $this->entityManager->getClassMetadata(DriveFile::class),
            $driveFile
        );
    }
}