<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure\Element;

use ProgramCms\ConfigBundle\App\Context;

/**
 * Class AbstractComposite
 * @package ProgramCms\ConfigBundle\Model\Structure\Element
 */
abstract class AbstractComposite extends \ProgramCms\ConfigBundle\Model\Structure\AbstractElement
{

    protected Iterator $_childrenIterator;

    /**
     * AbstractComposite constructor.
     * @param Context $context
     * @param Iterator $childrenIterator
     */
    public function __construct(
        Context $context,
        \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator $childrenIterator
    )
    {
        parent::__construct($context);
        $this->_childrenIterator = $childrenIterator;
    }

    /**
     * @param array $data
     */
    public function setData(array $data, $scope)
    {
        parent::setData($data, $scope);
        $children = array_key_exists(
            'children',
            $this->_data
        ) && is_array(
            $this->_data['children']
        ) ? $this->_data['children'] : [];
        $this->_childrenIterator->setElements($children, $scope);
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        foreach ($this->getChildren() as $child) {
            return (bool)$child;
        }
        return false;
    }

    /**
     * @return Iterator
     */
    public function getChildren()
    {
        return $this->_childrenIterator;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        if (parent::isVisible()) {
            return $this->hasChildren() || $this->getFrontendModel();
        }
        return false;
    }
}