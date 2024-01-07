<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

use Exception;
use ProgramCms\CoreBundle\View\Layout;
use ProgramCms\RouterBundle\Service\Url;
use Twig\Environment;

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
     * @var Environment
     */
    protected Environment $environment;
    /**
     * Current Block Layout
     * @var Layout
     */
    protected Layout $layout;
    /**
     * @var Url
     */
    protected Url $_url;

    /**
     * AbstractBlock constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->layout = $context->getLayout();
        $this->_url = $context->getUrl();
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
     * @param Layout $layout
     * @return $this
     */
    public function setLayout(Layout $layout): static
    {
        $this->layout = $layout;
        $this->_prepareLayout();
        return $this;
    }

    /**
     * Preparing global layout
     * You can redefine this method in "child classes" for changing layout
     * or accessing parent blocks
     * Cannot access child blocks from this method
     * @see _toHtml
     * @return $this
     */
    protected function _prepareLayout()
    {
        return $this;
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
     * Retrieves sorted list of child names
     * @return array
     */
    public function getChildNames(): array
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return [];
        }
        return $layout->getChildNames($this->getNameInLayout());
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
     * @return false|mixed|AbstractBlock
     */
    public function getChildBlock(string $alias): mixed
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
     * @return array
     */
    public function getChildBlocks(): array
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return [];
        }
        return $layout->getChildBlocks($this->getNameInLayout());
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

    /**
     * Set Child Block
     * @param $alias
     * @param $block
     * @return $this
     * @throws Exception
     */
    public function setChild($alias, $block): static
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return $this;
        }
        $thisName = $this->getNameInLayout();
        if ($layout->getChildName($thisName, $alias)) {
            $this->unsetChild($alias);
        }
        if ($block instanceof self) {
            $block = $block->getNameInLayout();
        }

        $layout->setChild($thisName, $block);

        return $this;
    }

    /**
     * Unset child block
     *
     * @param  string $alias
     * @return $this
     */
    public function unsetChild($alias): static
    {
        $layout = $this->getLayout();
        if (!$layout) {
            return $this;
        }
        $layout->unsetChild($this->getNameInLayout(), $alias);
        return $this;
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function getUrl($routeName, array $params = [])
    {
        return $this->_url->getUrlByRouteName($routeName, $params);
    }
}