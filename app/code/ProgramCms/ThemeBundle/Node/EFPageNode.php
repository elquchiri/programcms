<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use Twig\Environment;
use Twig\Source;

/**
 * Class EFPageNode
 * @package ProgramCms\ThemeBundle\Node
 */
class EFPageNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    protected Environment $environment;

    public function __construct(Environment $environment, $pageLayoutName, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], ['pageLayoutName' => $pageLayoutName], $lineno, $tag);
        $this->environment = $environment;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $efExtension = $this->environment->getExtension('\ProgramCms\ThemeBundle\Extension\EFThemeExtension');
        $pageLayoutName = $this->getAttribute('pageLayoutName');
        // Overrides page layout, used when rendering final page
        if(!empty($pageLayoutName)) {
            $efExtension->setCurrentPageLayout($pageLayoutName);
        }

        if($efExtension->canAddPageLayout($pageLayoutName)) {
            $efExtension->addEFPageLayout($pageLayoutName);

            $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($pageLayoutName);
            // We use the layout file name to use it later in the EFLayoutNode class
            $source = new Source($pageLayoutContents, $pageLayoutName);
            $nodes = $this->environment->parse($this->environment->tokenize($source));
            $compiler->subcompile($nodes->getNode('body'));
        }

        // Checks for Authorized EFPage children, throws an Exception if anything else found.
        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFContainerNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFReferenceContainerNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFCssNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFJsNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFTitleNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFUpdateNode):
                    break;
                case ($node instanceof \ProgramCms\ThemeBundle\Node\EFMoveNode):
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