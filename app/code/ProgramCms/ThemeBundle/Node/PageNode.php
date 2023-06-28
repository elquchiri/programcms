<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Source;

/**
 * Class EFPageNode
 * @package ProgramCms\ThemeBundle\Node
 */
class PageNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    /**
     * EFPageNode constructor.
     * @param $pageLayoutName
     * @param $body
     * @param $lineno
     * @param null $tag
     */
    public function __construct($pageLayoutName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['pageLayoutName' => $pageLayoutName], $lineno, $tag);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $efExtension = $compiler->getEnvironment()->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout();
        $pageLayoutName = $this->getAttribute('pageLayoutName');
        // Overrides page layout, used when rendering final page
        if(!empty($pageLayoutName)) {
            $efExtension->setCurrentPageLayout($pageLayoutName);
        }

        if($efExtension->canAddPageLayout($pageLayoutName)) {
            $efExtension->addPageLayout($pageLayoutName);

            $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($pageLayoutName);
            // We use the layout file name to use it later in the EFLayoutNode class
            $source = new Source($pageLayoutContents, $pageLayoutName);
            $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));
            $compiler->subcompile($nodes->getNode('body'));
        }

        // Checks for Authorized EFPage children, throws an Exception if anything else found.
        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\ReferenceContainerNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\CssNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\JsNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\TitleNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\UpdateNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\MoveNode):
                case ($node instanceof \ProgramCms\ThemeBundle\Node\ContainerNode):
                    break;
                case ($node instanceof \Twig\Node\TextNode):
                    if(empty(trim($node->getAttribute('data')))) {
                        break;
                    }
                default:
                    throw new \Exception(sprintf("%s is not a supported Tag inside EFPage Layouts.", $node->getNodeTag()));
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}