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
 * Class EFUpdateNode
 * @package ProgramCms\ThemeBundle\Node
 */
class UpdateNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{

    public function __construct($handle, $lineno, $tag = null)
    {
        parent::__construct([], ['handle' => $handle], $lineno, $tag);
    }

    /**
     * @throws \Twig\Error\SyntaxError
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $efExtension = $compiler->getEnvironment()->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout();
        $handle = $this->getAttribute('handle');

        if($efExtension->canAddPageLayout($handle)) {
            $efExtension->addPageLayout($handle);

            /** @var \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout */
            $pageLayout = $efExtension->getPageLayout();
            $pageLayoutContents = $pageLayout->getPageLayoutContents($handle);

            // Prepare layout file to be parsed as by the LayoutNode
            $source = new Source($pageLayoutContents, $handle);

            $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));

            $compiler->subcompile($nodes->getNode('body'));
        }
    }
}