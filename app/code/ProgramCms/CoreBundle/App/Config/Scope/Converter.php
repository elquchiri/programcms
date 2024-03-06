<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config\Scope;

use ProgramCms\CoreBundle\App\Config\ConverterInterface;

/**
 * Class Converter
 * @package ProgramCms\CoreBundle\App\Config\Scope
 */
class Converter implements ConverterInterface
{
    /**
     * @param $source
     * @return array
     */
    public function convert($source)
    {
        $output = [];
        foreach ($source as $key => $value) {
            $this->_setArrayValue($output, $key, $value);
        }
        return $output;
    }

    /**
     * @param array $container
     * @param $path
     * @param $value
     */
    protected function _setArrayValue(array &$container, $path, $value)
    {
        $segments = explode('/', $path);
        $currentPointer = & $container;
        foreach ($segments as $segment) {
            if (!isset($currentPointer[$segment])) {
                $currentPointer[$segment] = [];
            }
            $currentPointer = & $currentPointer[$segment];
        }
        $currentPointer = $value;
    }
}