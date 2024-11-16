<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Controller\Adminhtml\Ajax;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\DriveBundle\Entity\DriveFile;
use ProgramCms\DriveBundle\Repository\DriveFileRepository;

/**
 * Class FileController
 * @package ProgramCms\DriveBundle\Controller\Adminhtml\Ajax
 */
class FileController extends AdminController
{
    /**
     * @var DriveFileRepository
     */
    protected DriveFileRepository $driveFileRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param DriveFileRepository $driveFileRepository
     */
    public function __construct(
        Context $context,
        DriveFileRepository $driveFileRepository
    )
    {
        parent::__construct($context);
        $this->driveFileRepository = $driveFileRepository;
    }

    public function execute()
    {
        $fileId = (int) $this->getRequest()->getParam('id');
        $json = ['success' => false];

        /** @var DriveFile $file */
        $file = $this->driveFileRepository->getById($fileId);
        if($file) {
            $json['file'] = [
                'name' => $file->getName(),
                'extension' => strtoupper($file->getShortMimeType()) . ' (' . $file->getExtension() . ')',
                'size' => $file->getSize() . " KB",
                'mime' => $file->getMimeType(),
                'created_at' => $file->getCreatedAt()->format('Y-m-d h:m:s'),
                'updated_at' => $file->getUpdatedAt()->format('Y-m-d h:m:s'),
                'perms' => $file->getPerms()
            ];
            $json['success'] = true;
        }

        return $this->json($json);
    }
}