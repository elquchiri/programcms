<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Setup;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface DriveManagerInterface
 * @package ProgramCms\DriveBundle\Setup
 */
interface DriveManagerInterface
{
    /**
     * @param UploadedFile $file
     * @param string $destination
     * @param string $newFilename
     * @return mixed
     */
    public function move(UploadedFile $file, string $destination, string $newFilename);
}