<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

use Exception;

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
     * @var array
     */
    protected static array $_underscoreCache = [];

    /**
     * DataObject constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        $this->data = $data;
    }

    /**
     * Add Data to the object and keeps previous data
     * @param array $arr
     * @return $this
     */
    public function addData(array $arr): static
    {
        if ($this->data === []) {
            $this->setData($arr);
            return $this;
        }

        foreach ($arr as $index => $value) {
            $this->setData($index, $value);
        }
        return $this;
    }

    /**
     * @param $argument
     * @param null $value
     * @return DataObject
     */
    public function setData($argument, mixed $value = null): static
    {
        if(is_array($argument)) {
            $this->data = $argument;
        }else{
            $this->data[$argument] = $value;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param null $index
     * @return array|mixed
     */
    public function getData(string $key = '', $index = null)
    {
        if ('' === $key) {
            return $this->data;
        }

        /* process a/b/c key as ['a']['b']['c'] */
        if (str_contains($key, '/')) {
            $data = $this->getDataByPath($key);
        } else {
            $data = $this->_getData($key);
        }

        if ($index !== null) {
            if ($data === (array)$data) {
                $data = $data[$index] ?? null;
            } elseif (is_string($data)) {
                $data = explode(PHP_EOL, $data);
                $data = $data[$index] ?? null;
            } elseif ($data instanceof self) {
                $data = $data->getData($index);
            } else {
                $data = null;
            }
        }
        return $data;
    }

    /**
     * @param $path
     * @return mixed|null
     */
    public function getDataByPath($path)
    {
        $keys = explode('/', $path);

        $data = $this->data;
        foreach ($keys as $key) {
            if ((array)$data === $data && isset($data[$key])) {
                $data = $data[$key];
            } elseif ($data instanceof self) {
                $data = $data->getDataByKey($key);
            } else {
                return null;
            }
        }
        return $data;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getDataByKey($key)
    {
        return $this->_getData($key);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    protected function _getData($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
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
     * @param string $method
     * @param array $arguments
     * @return array|bool|mixed|DataObject|null
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        switch (substr($method, 0, 3)) {
            case 'get':
                $key = $this->_underscore(substr($method, 3));
                return $this->getData($key);
            case 'set':
                $key = $this->_underscore(substr($method, 3));
                $value = isset($arguments[0]) ? $arguments[0] : null;
                return $this->setData($key, $value);
            case 'uns':
                $key = $this->_underscore(substr($method, 3));
                return $this->unsetData($key);
            case 'has':
                $key = $this->_underscore(substr($method, 3));
                return $this->hasData($key);
        }
        throw new Exception(
            sprintf('Invalid method %1::%2', get_class($this), $method)
        );
    }

    /**
     * Set object data with calling setter method
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setDataUsingMethod(string $key, mixed $value): static
    {
        $method = 'set' . str_replace('_', '', ucwords($key, '_'));
        $this->{$method}($value);
        return $this;
    }

    /**
     * Get object data by key with calling getter method
     * @param string $key
     * @param mixed|null $args
     * @return mixed
     */
    public function getDataUsingMethod(string $key, mixed $args = null): mixed
    {
        $method = 'get' . str_replace('_', '', ucwords($key, '_'));
        return $this->{$method}($args);
    }

    /**
     * Has object data by key by checking method
     * @param string $key
     * @param mixed|null $args
     * @return mixed
     */
    public function hasDataUsingMethod(string $key, mixed $args = null): mixed
    {
        $method = 'get' . str_replace('_', '', ucwords($key, '_'));
        return method_exists($this, $method);
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