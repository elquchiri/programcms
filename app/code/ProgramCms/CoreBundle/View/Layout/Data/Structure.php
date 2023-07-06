<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Layout\Data;

use Exception;

/**
 * Class Structure
 * @package ProgramCms\CoreBundle\View\Layout\Data
 */
class Structure extends \ProgramCms\CoreBundle\Data\Structure
{

    /**
     * Register an element in structure, predefine element type internally
     * @param string $name
     * @param string $type
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function createStructuralElement(string $name, string $type, array $data = []): string
    {
        $this->createElement($name, array_merge(['type' => $type], $data));
        return $name;
    }

    /**
     * Reorder a child of a specified element
     *
     * If $offsetOrSibling is null, it will put the element to the end
     * If $offsetOrSibling is numeric (integer) value, it will put the element after/before specified position
     * Otherwise -- after/before specified sibling
     *
     * @param string $parentName
     * @param string $childName
     * @param string|int|null $offsetOrSibling
     * @param bool $after
     * @return void
     */
    public function reorderChildElement($parentName, $childName, $offsetOrSibling, $after = true)
    {
        if (is_numeric($offsetOrSibling)) {
            $offset = abs((int) $offsetOrSibling) * ($after ? 1 : -1);
            $this->reorderChild($parentName, $childName, $offset);
        } elseif (null === $offsetOrSibling) {
            $this->reorderChild($parentName, $childName, null);
        } else {
            $children = array_keys($this->getChildren($parentName));
            if ($this->getChildId($parentName, $offsetOrSibling) !== false) {
                $offsetOrSibling = $this->getChildId($parentName, $offsetOrSibling);
            }
            $sibling = $this->_filterSearchMinus($offsetOrSibling, $children, $after);
            if ($childName !== $sibling) {
                $siblingParentName = $this->getParentId($sibling);
                if ($parentName !== $siblingParentName) {
                    // "Broken reference: the '{$childName}' tries to reorder itself towards '{$sibling}', but " .
                    // "their parents are different: '{$parentName}' and '{$siblingParentName}' respectively."
                    return;
                }
                $this->reorderToSibling($parentName, $childName, $sibling, $after ? 1 : -1);
            }
        }
    }

    /**
     * Search for an array element using needle, but needle may be '-', which means "first" or "last" element
     *
     * Returns first or last element in the haystack, or the $needle argument
     *
     * @param string $needle
     * @param array $haystack
     * @param bool $isLast
     * @return string
     */
    protected function _filterSearchMinus($needle, array $haystack, $isLast)
    {
        if ('-' === $needle) {
            if ($isLast) {
                return array_pop($haystack);
            }
            return array_shift($haystack);
        }
        return $needle;
    }

    /**
     * Reorder an element relatively to its sibling
     *
     * $offset possible values:
     *    1,  2 -- set after the sibling towards end -- by 1, by 2 positions, etc
     *   -1, -2 -- set before the sibling towards start -- by 1, by 2 positions, etc...
     *
     * Both $childId and $siblingId must be children of the specified $parentId
     * Returns new position of the reordered element
     *
     * @param string $parentId
     * @param string $childId
     * @param string $siblingId
     * @param int $offset
     * @return int
     */
    public function reorderToSibling($parentId, $childId, $siblingId, $offset)
    {
        $this->_getChildOffset($parentId, $childId);
        if ($childId === $siblingId) {
            $newOffset = $this->_getRelativeOffset($parentId, $siblingId, $offset);
            return $this->reorderChild($parentId, $childId, $newOffset);
        }
        $newOffset = $this->unsetChild($childId)->_getRelativeOffset($parentId, $siblingId, $offset);
        $this->_insertChild($parentId, $childId, $newOffset);
        return $this->_getChildOffset($parentId, $childId) + 1;
    }

    /**
     * Calculate new offset for placing an element relatively specified sibling under the same parent
     *
     * @param string $parentId
     * @param string $siblingId
     * @param int $delta
     * @return int
     */
    private function _getRelativeOffset($parentId, $siblingId, $delta)
    {
        $newOffset = $this->_getChildOffset($parentId, $siblingId) + $delta;
        if ($delta < 0) {
            $newOffset += 1;
        }
        if ($newOffset < 0) {
            $newOffset = 0;
        }
        return $newOffset;
    }
}