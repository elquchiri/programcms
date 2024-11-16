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
 * Class IndexController
 * @package ProgramCms\DriveBundle\Controller\Adminhtml\Ajax
 */
class IndexController extends AdminController
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
        $json = [];
        $files = $this->driveFileRepository->findAll();
        /** @var DriveFile $file */
        foreach($files as $file) {
            $json[] = [
                'id' => $file->getEntityId(),
                'name' => $file->getName(),
                'path' => $file->getPath(),
                'size' => $file->getSize(),
                'extension' => $file->getExtension(),
                'mime' => $file->getShortMimeType(),
                'type' => $file->getType()
            ];
        }

        return $this->json($json);
    }
}