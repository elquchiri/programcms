<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Node;

use ProgramCms\ThemeBundle\Model\PageLayout;
use ProgramCms\ThemeBundle\Node\AbstractNode;
use ReflectionException;
use Twig\Compiler;
use Twig\Error\SyntaxError;
use Twig\Source;

/**
 * Class UiComponentNode
 * @package ProgramCms\UiBundle\Twig\Node
 */
class UiComponentNodeOld extends AbstractNode implements \Twig\Node\NodeCaptureInterface
{

    /**
     * @param Compiler $compiler
     * @return void
     * @throws ReflectionException
     * @throws SyntaxError
     */
    protected function _compile(Compiler &$compiler)
    {
        $efExtension = $compiler->getEnvironment()->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout();
        $componentName = $this->getAttribute('name');

        /** @var PageLayout $pageLayout */
        $pageLayout = $efExtension->getPageLayout();
        $componentContents = $this->_minifySource($pageLayout->getUiComponentContents($componentName));

        // Prepare component file to be parsed by the LayoutNode
        $source = new Source($componentContents, $componentName);

        $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));
        $bodyNode = $nodes->getNode('body');

        dd($bodyNode);

        foreach($bodyNode as &$childNodes) {
            foreach($childNodes as $childNode) {
                if (!($childNode instanceof AbstractNodeComponent)) {
                    continue;
                }

                if ($childNode->hasAttribute('name') && $childNode->getAttribute('name') == $componentName) {
                    if ($this->hasAttribute('parent')) {
                        $parentNode = $this->getAttribute('parent');
                        $childNode->setAttribute('parent', $parentNode);
                    }
                }
            }
        }

        $compiler->subcompile($bodyNode);
    }
}