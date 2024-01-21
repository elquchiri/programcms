<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Data\Process;

/**
 * Class Sort
 * @package ProgramCms\CoreBundle\Data\Process
 */
class Sort
{
    /**
     * Sort Array by Key and Mode
     * @param $array
     * @param $key
     * @param $sortOrder
     * @return array
     */
    public function sortArrayByKey($array, $key, $sortOrder): array
    {
        if(count($array) > 1) {
            $sortOrder = strtolower($sortOrder);
            uasort($array, function ($a, $b) use ($key, $sortOrder) {
                if ($a[$key] == $b[$key]) {
                    return 0;
                }

                if ($sortOrder === 'asc') {
                    return ($a[$key] < $b[$key]) ? -1 : 1;
                } else if ($sortOrder === 'desc') {
                    return ($a[$key] > $b[$key]) ? -1 : 1;
                }

                // By default, return ASC
                return ($a[$key] < $b[$key]) ? -1 : 1;
            });
        }

        return $array;
    }
}