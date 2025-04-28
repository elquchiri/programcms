<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

use ProgramCms\ConfigBundle\Model\Structure\AbstractElement;

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
     * @var AbstractElement
     */
    protected AbstractElement $_flyweight;

    /**
     * @var string
     */
    protected string $_lastId;

    protected $_scope;

    /**
     * Iterator constructor.
     * @param AbstractElement $element
     */
    public function __construct(AbstractElement $element)
    {
        $this->_flyweight = $element;
    }

    /**
     * @param array $elements
     * @param $scope
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
     * @return AbstractElement
     */
    public function current(): AbstractElement
    {
        return $this->_flyweight;
    }

    /**
     * @return void
     */
    public function next(): void
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
    public function valid(): bool
    {
        return (bool)current($this->_elements);
    }

    /**
     * @return void
     */
    public function rewind(): void
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
     * @param AbstractElement $element
     * @return bool
     */
    public function isLast(AbstractElement $element): bool
    {
        return $element->getId() == $this->_lastId;
    }
}