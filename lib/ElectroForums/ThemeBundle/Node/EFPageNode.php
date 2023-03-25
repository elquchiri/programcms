<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


use Twig\Environment;
use Twig\Source;

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
        $efExtension = $this->environment->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension');

        $pageLayoutName = $this->getAttribute('pageLayoutName');

        if($efExtension->canAddPageLayout($pageLayoutName)) {
            $efExtension->addEFPageLayout($pageLayoutName);

            $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($pageLayoutName);
            $source = new Source($pageLayoutContents, 'PageLayout');
            $nodes = $this->environment->parse($this->environment->tokenize($source));
            $compiler->subcompile($nodes->getNode('body'));
        }

        // Checks for Authorized EFPage children, throws an Exception if anything else found.
        foreach($this->getNode('body') as $node) {
            switch($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode):
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFCssNode):
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFJsNode):
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFTitleNode):
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFUpdateNode):
                    break;
                case ($node instanceof \Twig\Node\TextNode):
                    if(empty(trim($node->getAttribute('data')))) {
                        break;
                    }
                default:
                    throw new \Exception(sprintf("%s is not an ElectroForums supported Tag inside EFPage Layouts.", $node->getNodeTag()));
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}