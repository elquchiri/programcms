<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

/**
 * Class Iterator
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
abstract class Iterator implements \Iterator
{
    /**
     * @var array
     */
    protected array $_elements;
    /**
     * @var \ProgramCms\ConfigBundle\Model\Structure\AbstractElement
     */
    protected $_flyweight;
    /**
     * @var string
     */
    protected string $_lastId;

    protected $_scope;

    /**
     * Iterator constructor.
     * @param \ProgramCms\ConfigBundle\Model\Structure\AbstractElement $element
     */
    public function __construct(\ProgramCms\ConfigBundle\Model\Structure\AbstractElement $element)
    {
        $this->_flyweight = $element;
    }

    /**
     * @param array $elements
     */
    public function setElements(array $elements, $scope)
    {
        $this->_elements = $elements;
        $this->_scope = $scope;
        if (count($elements)) {
            $lastElement = end($elements);
            $this->_lastId = $lastElement['id'];
        }
    }

    /**
     * @return mixed|\ProgramCms\ConfigBundle\Model\Structure\AbstractElement
     */
    public function current()
    {
        return $this->_flyweight;
    }

    public function next()
    {
        next($this->_elements);
        if (current($this->_elements)) {
            $this->_initFlyweight(current($this->_elements));
            if (!$this->current()->isVisible()) {
                $this->next();
            }
        }
    }

    /**
     * @param array $element
     */
    protected function _initFlyweight(array $element)
    {
        $this->_flyweight->setData($element, $this->_scope);
    }

    public function key()
    {
        key($this->_elements);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return (bool)current($this->_elements);
    }

    public function rewind()
    {
        reset($this->_elements);
        if (current($this->_elements)) {
            $this->_initFlyweight(current($this->_elements));
            if (!$this->current()->isVisible()) {
                $this->next();
            }
        }
    }

    /**
     * @param \ProgramCms\ConfigBundle\Model\Structure\AbstractElement $element
     * @return bool
     */
    public function isLast(\ProgramCms\ConfigBundle\Model\Structure\AbstractElement $element)
    {
        return $element->getId() == $this->_lastId;
    }
}