<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Helper;

/**
 * Class FileHelper
 * @package ProgramCms\DriveBundle\Helper
 */
class FileHelper
{
    /**
     * @param $perms
     * @return array
     */
    public function permsToArray($perms): array
    {
        // Get only the last three digits (e.g., for 16877 it would be 755)
        $octal = substr(sprintf('%o', $perms), -3);

        // Map each digit to read, write, execute permissions
        $permissionArray = [];
        foreach (str_split($octal) as $digit) {
            $permissionArray[] = [
                (bool)(($digit & 4)),
                (bool)(($digit & 2)),
                (bool)(($digit & 1))
            ];
        }

        return $permissionArray;
    }
}