<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Serialize\Serializer;

use InvalidArgumentException;
use ProgramCms\CoreBundle\Serialize\SerializerInterface;

/**
 * Class Json
 * @package ProgramCms\CoreBundle\Serialize\Serializer
 */
class Json implements SerializerInterface
{
    /**
     * @param $data
     * @return string
     */
    public function serialize($data)
    {
        $result = json_encode($data);
        if (false === $result) {
            throw new InvalidArgumentException("Unable to serialize value. Error: " . json_last_error_msg());
        }
        return $result;
    }

    /**
     * @param $string
     * @return mixed
     */
    public function unserialize($string)
    {
        if ($string === null) {
            throw new InvalidArgumentException(
                'Unable to unserialize value. Parameter must be a string type, null given.'
            );
        }
        $result = json_decode($string, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Unable to unserialize value. " . json_last_error_msg());
        }
        return $result;
    }
}