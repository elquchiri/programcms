<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Data;

use Exception;

/**
 * An associative data structure, that features "nested set" parent-child relations
 * Class Structure
 * @package ProgramCms\CoreBundle\Data
 */
class Structure
{
    const CHILDREN = 'children';

    const PARENT = 'parent';

    /**
     * Holds Page key,value elements Tree
     * @var array
     */
    private array $elements = [];

    /**
     * Get child ID by parent ID and alias
     * @param $parentId
     * @param $alias
     * @return false|int|string
     */
    public function getChildId($parentId, $alias): bool|int|string
    {
        if (isset($this->elements[$parentId][self::CHILDREN])) {
            return array_search($alias, $this->elements[$parentId][self::CHILDREN]);
        }
        return false;
    }

    /**
     * Create new element
     *
     * @param string $elementId
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function createElement(string $elementId, array $data): void
    {
        if (isset($this->elements[$elementId])) {
            throw new Exception(sprintf("An element with a %s ID already exists.", $elementId));
        }
        $this->elements[$elementId] = [];
        foreach ($data as $key => $value) {
            $this->setAttribute($elementId, $key, $value);
        }
    }

    /**
     * @param $elementId
     * @param null $alias
     * @return $this
     */
    public function unsetChild($elementId, $alias = null): static
    {
        if (null === $alias) {
            $childId = $elementId;
        } else {
            $childId = $this->getChildId($elementId, $alias);
        }
        $parentId = $this->getParentId($childId);
        unset($this->elements[$childId][self::PARENT]);
        if ($parentId) {
            unset($this->elements[$parentId][self::CHILDREN][$childId]);
            if (empty($this->elements[$parentId][self::CHILDREN])) {
                unset($this->elements[$parentId][self::CHILDREN]);
            }
        }
        return $this;
    }

    /**
     * Set element as a child to another element
     *
     * @param string $elementId
     * @param string $parentId
     * @param string $alias
     * @param int|null $position
     * @return void
     * @throws Exception if attempting to set parent as child to its child (recursively)
     * @see _insertChild() for position explanation
     */
    public function setAsChild(string $elementId, string $parentId, int $position = null)
    {
        if ($elementId == $parentId) {
            throw new Exception(
                sprintf(
                    'The "%s" was incorrectly set as a child to itself. Resolve the issue and try again.',
                    $elementId
                )
            );
        }
        if ($this->_isParentRecursively($elementId, $parentId)) {
            throw new Exception(
                sprintf(
                    'The "%s" cannot be set as child to "%s" because "%s" is a parent of "%s" recursively. ' .
                    $elementId, $parentId, $parentId, $elementId
                )
            );
        }
        $this->unsetChild($elementId);
        unset($this->elements[$parentId][self::CHILDREN][$elementId]);
        $this->_insertChild($parentId, $elementId, $position);
    }

    /**
     * Remove element with specified ID from the structure
     * Can recursively delete all child elements.
     * Returns false if there was no element found, therefore was nothing to delete.
     * @param string $elementId
     * @param bool $recursive
     * @return bool
     * @throws Exception
     */
    public function unsetElement(string $elementId, bool $recursive = true): bool
    {
        if (isset($this->elements[$elementId][self::CHILDREN])) {
            foreach (array_keys($this->elements[$elementId][self::CHILDREN]) as $childId) {
                $this->_assertElementExists($childId);
                if ($recursive) {
                    $this->unsetElement($childId, $recursive);
                } else {
                    unset($this->elements[$childId][self::PARENT]);
                }
            }
        }
        $this->unsetChild($elementId);
        $wasFound = isset($this->elements[$elementId]);
        unset($this->elements[$elementId]);
        return $wasFound;
    }

    /**
     * Get element attribute
     * @param string $elementId
     * @param string $attribute
     * @return mixed
     * @throws Exception
     */
    public function getAttribute(string $elementId, string $attribute): mixed
    {
        $this->_assertElementExists($elementId);
        if (isset($this->elements[$elementId][$attribute])) {
            return $this->elements[$elementId][$attribute];
        }
        return false;
    }

    /**
     * Get all children
     * @param string $parentId
     * @return array
     */
    public function getChildren(string $parentId): array
    {
        return $this->elements[$parentId][self::CHILDREN] ?? [];
    }

    /**
     * Get name of parent element
     * @param string $childId
     * @return string|bool
     */
    public function getParentId(string $childId): bool|string
    {
        return $this->elements[$childId][self::PARENT] ?? false;
    }

    /**
     * Set an arbitrary value to specified element attribute
     * @param string $elementId
     * @param string $attribute
     * @param mixed $value
     * @return $this
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function setAttribute(string $elementId, string $attribute, mixed $value): static
    {
        $this->_assertElementExists($elementId);
        switch ($attribute) {
            case self::CHILDREN:
                throw new \InvalidArgumentException("The '{$attribute}' attribute is reserved and can't be set.");
            default:
                $this->elements[$elementId][$attribute] = $value;
        }
        return $this;
    }

    /**
     * Whether specified element exists
     * @param string $elementId
     * @return bool
     */
    public function hasElement(string $elementId): bool
    {
        return isset($this->elements[$elementId]);
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * Traverse through hierarchy and detect if the "potential parent" is a parent recursively to specified "child"
     * @param string $childId
     * @param string $potentialParentId
     * @return bool
     */
    private function _isParentRecursively(string $childId, string $potentialParentId): bool
    {
        $parentId = $this->getParentId($potentialParentId);
        if (!$parentId) {
            return false;
        }
        if ($parentId === $childId) {
            return true;
        }
        return $this->_isParentRecursively($childId, $parentId);
    }

    /**
     * Insert an existing element as a child to existing element
     * The element must not be a child to any other element
     * The target parent element must not have it as a child already
     * @param string $targetParentId
     * @param string $elementId
     * @param int|null $offset
     * @param string $alias
     * @return void
     * @throws Exception
     */
    protected function _insertChild(string $targetParentId, string $elementId, ?int $offset): void
    {
        // validate
        $this->_assertElementExists($elementId);
        if (!empty($this->elements[$elementId][self::PARENT])) {
            throw new Exception(
                sprintf(
                    'The element "%s" can\'t have a parent because "%s" is already the parent of "%s".',
                    $elementId, $this->elements[$elementId][self::PARENT]
                )
            );
        }
        $this->_assertElementExists($targetParentId);
        $children = $this->getChildren($targetParentId);
        if (isset($children[$elementId])) {
            throw new Exception(
                sprintf(
                    'The element "%s" is already a child of "%s".',
                    $elementId, $targetParentId
                )
            );
        }
        if (false !== array_search($elementId, $children)) {
            throw new Exception(
                sprintf(
                    'The element "%s" can\'t have a child because "%s" already has a child with alias "%s".',
                    $targetParentId, $elementId
                )
            );
        }

        // insert
        if (null === $offset) {
            $offset = count($children);
        }
        $this->elements[$targetParentId][self::CHILDREN] = array_merge(
            array_slice($children, 0, $offset),
            [$elementId => $elementId],
            array_slice($children, $offset)
        );
        $this->elements[$elementId][self::PARENT] = $targetParentId;
    }

    /**
     * Get element alias by name
     * @param string $parentId
     * @param string $childId
     * @return string|bool
     */
    public function getChildAlias($parentId, $childId): bool|string
    {
        if (isset($this->elements[$parentId][self::CHILDREN][$childId])) {
            return $this->elements[$parentId][self::CHILDREN][$childId];
        }
        return false;
    }

    /**
     * Calculate a relative offset of a child element in specified parent
     * @param string $parentId
     * @param string $childId
     * @return int
     * @throws Exception
     */
    protected function _getChildOffset($parentId, $childId): int
    {
        $index = array_search($childId, array_keys($this->getChildren($parentId)));
        if (false === $index) {
            throw new Exception(
                sprintf(
                    'The "%1" is not a child of "%2". Resolve the issue and try again.',
                    [$childId, $parentId]
                )
            );
        }
        return $index;
    }

    /**
     * Reorder a child element relatively to specified position
     * Returns new position of the reordered element
     * @param string $parentId
     * @param string $childId
     * @param int|null $position
     * @return int
     * @throws Exception
     * @see _insertChild() for position explanation
     */
    public function reorderChild($parentId, $childId, $position)
    {
        $alias = $this->getChildAlias($parentId, $childId);
        $currentOffset = $this->_getChildOffset($parentId, $childId);
        $offset = $position;
        if ($position > 0) {
            if ($position >= $currentOffset + 1) {
                $offset -= 1;
            }
        } elseif ($position < 0) {
            if ($position < $currentOffset + 1 - count($this->elements[$parentId][self::CHILDREN])) {
                if ($position === -1) {
                    $offset = null;
                } else {
                    $offset += 1;
                }
            }
        }
        $this->unsetChild($childId)->_insertChild($parentId, $childId, $offset);
        return $this->_getChildOffset($parentId, $childId) + 1;
    }

    /**
     * Check if specified element exists
     * @param string $elementId
     * @return void
     * @throws Exception if doesn't exist
     */
    private function _assertElementExists(string $elementId)
    {
        if (!isset($this->elements[$elementId])) {
            throw new \OutOfBoundsException(
                'The element with the "' . $elementId . '" ID wasn\'t found. Verify the ID and try again.'
            );
        }
    }

    /**
     * Check if it is an array
     * @param array $value
     * @return void
     * @throws Exception
     */
    private function _assertArray(mixed $value)
    {
        if (!is_array($value)) {
            throw new Exception("An array expected: " . var_export($value, 1));
        }
    }
}