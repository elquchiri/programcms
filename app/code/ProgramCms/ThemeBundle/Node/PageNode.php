<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Compiler;
use Twig\Error\SyntaxError;
use Twig\Source;

/**
 * Class PageNode
 * @package ProgramCms\ThemeBundle\Node
 */
class PageNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
{

    /**
     * @param Compiler $compiler
     * @return void
     * @throws SyntaxError
     */
    protected function _compile(Compiler &$compiler)
    {
        $efExtension = $compiler->getEnvironment()->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout();
        $pageLayoutName = $this->getAttribute('pageLayoutName');
        // Overrides page layout, used when rendering final page
        if(!empty($pageLayoutName)) {
            $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->setCurrentPageLayout('$pageLayoutName');");
        }

        if($efExtension->canAddPageLayout($pageLayoutName)) {
            $efExtension->addPageLayout($pageLayoutName);
            $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addPageLayout('$pageLayoutName');");

            $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($pageLayoutName);
            // We use the layout file name to use it later in the LayoutNode class
            $source = new Source($pageLayoutContents, $pageLayoutName);
            $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));
            $compiler->subcompile($nodes->getNode('body'));
        }
    }
}