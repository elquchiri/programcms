<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

/**
 * Represents a Data Object Entity
 * Class DataObject
 * @package ProgramCms\CoreBundle\Model
 */
class DataObject
{
    /**
     * @var array
     */
    protected array $data = [];
    /**
     * Setter/Getter underscore transformation cache
     *
     * @var array
     */
    protected static array $_underscoreCache = [];

    /**
     * @param $argument
     * @param null $value
     */
    public function setData($argument, $value = null): static
    {
        if(is_array($argument)) {
            $this->data = $argument;
        }else{
            $this->data[$argument] = $value;
        }
        return $this;
    }
    /**
     * @param null $argument
     * @return array|mixed
     */
    public function getData($argument = null): mixed
    {
        if($argument) {
            return $this->data[$argument];
        }
        return $this->data;
    }
    /**
     * @param $argument
     * @return bool
     */
    public function hasData($argument): bool
    {
        return isset($this->data[$argument]);
    }

    /**
     * @param $argument
     * @return $this
     */
    public function unsetData($argument): static
    {
        if ($argument === null) {
            $this->setData([]);
        } elseif (is_string($argument)) {
            if (isset($this->data[$argument]) || array_key_exists($argument, $this->data)) {
                unset($this->data[$argument]);
            }
        } elseif ($argument === (array)$argument) {
            foreach ($argument as $element) {
                $this->unsetData($element);
            }
        }
        return $this;
    }
    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call(string $name, array $arguments)
    {
        switch (substr($name, 0, 3)) {
            case 'get':
                $key = $this->_underscore(substr($name, 3));
                return $this->getData($key);
            case 'set':
                $key = $this->_underscore(substr($name, 3));
                $value = isset($arguments[0]) ? $arguments[0] : null;
                return $this->setData($key, $value);
            case 'uns':
                $key = $this->_underscore(substr($name, 3));
                return $this->unsetData($key);
            case 'has':
                $key = $this->_underscore(substr($name, 3));
                return $this->hasData($key);
        }
    }

    /**
     * @param $name
     * @return string
     */
    protected function _underscore($name): string
    {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }
        $result = strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', "_$1", $name), '_'));
        self::$_underscoreCache[$name] = $result;
        return $result;
    }
}