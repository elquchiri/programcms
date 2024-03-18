<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Serialize;

/**
 * Interface SerializerInterface
 * @package ProgramCms\CoreBundle\Serialize
 */
interface SerializerInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function serialize($data);

    /**
     * @param $string
     * @return mixed
     */
    public function unserialize($string);
}