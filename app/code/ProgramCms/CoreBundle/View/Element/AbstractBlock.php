<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

use Exception;
use InvalidArgumentException;
use ProgramCms\CoreBundle\View\Layout;

/**
 * Class AbstractBlock
 * @package ProgramCms\CoreBundle\View\Element
 */
abstract class AbstractBlock extends \ProgramCms\CoreBundle\Model\DataObject implements BlockInterface
{
    /**
     * Block name in layout
     * @var string
     */
    protected string $_nameInLayout;
    /**
     * Twig Environment instance
     * @var \Twig\Environment
     */
    protected \Twig\Environment $environment;
    /**
     * Current Block Layout
     * @var Layout
     */
    protected Layout $layout;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->layout = $context->getLayout();
        $this->_construct();
    }

    /**
     * Internal constructor, that is called from real constructor
     * @return void
     */
    protected function _construct()
    {
        // Please override this one instead of overriding real __construct constructor
    }

    /**
     * Set current block's name in layout
     * @param $name
     */
    public function setNameInLayout($name)
    {
        $this->_nameInLayout = $name;
    }

    /**
     * Get block's name in layout
     * @return string
     */
    public function getNameInLayout(): string
    {
        return $this->_nameInLayout;
    }

    /**
     * Accessing layout from Template classes
     * @return Layout
     */
    public function getLayout(): Layout
    {
        return $this->layout;
    }

    /**
     * @return string
     */
    public function toHtml(): string
    {
        return $this->_toHtml();
    }

    /**
     * Created to be Overridden, called in toHtml public method
     * @return string
     */
    protected function _toHtml(): string
    {
        return '';
    }

    /**
     * Retrieve child block content by name
     * @param string $alias
     * @return string
     * @throws Exception
     */
    public function getChildHtml(string $alias = ''): string
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return '';
        }
        $name = $this->getNameInLayout();
        $out = '';
        if ($alias) {
            $childName = $layout->getChildName($name, $alias);
            if ($childName) {
                $out = $layout->renderElement($childName);
            }
        } else {
            foreach ($layout->getChildNames($name) as $child) {
                $out .= $layout->renderElement($child);
            }
        }

        return $out;
    }

    /**
     * @param string $alias
     * @throws InvalidArgumentException
     */
    public function getChildBlock(string $alias)
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return false;
        }
        $name = $layout->getChildName($this->getNameInLayout(), $alias);
        if ($name) {
            return $layout->getBlock($name);
        }
        return false;
    }

    /**
     * @param $name
     * @param null $value
     * @return $this
     */
    public function setAttribute($name, $value = null): static
    {
        return $this->setData($name, $value);
    }
}