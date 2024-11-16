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
 * Class SearchController
 * @package ProgramCms\DriveBundle\Controller\Adminhtml\Ajax
 */
class SearchController extends AdminController
{
    /**
     * @var DriveFileRepository
     */
    protected DriveFileRepository $driveFileRepository;

    /**
     * SearchController constructor.
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
        $result = ['success' => false];
        $results = [];
        $qWord = $this->getRequest()->getParam('drive_search');
        $search = $this->driveFileRepository->findByKeyword($qWord);
        /** @var DriveFile $occurrence */
        foreach($search as $occurrence) {
            $results[] = [
                'id' => $occurrence->getEntityId(),
                'path' => $occurrence->getPath(),
                'name' => $occurrence->getName(),
                'extension' => $occurrence->getExtension()
            ];
        }
        $result['data'] = $results;
        $result['success'] = true;
        return $this->json($result);
    }
}