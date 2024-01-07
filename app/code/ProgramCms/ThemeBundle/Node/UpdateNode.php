<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

use ProgramCms\ThemeBundle\Model\PageLayout;
use ReflectionException;
use Twig\Error\SyntaxError;
use Twig\Source;
use Twig\Compiler;

/**
 * Class UpdateNode
 * @package ProgramCms\ThemeBundle\Node
 */
class UpdateNode extends AbstractNode implements \Twig\Node\NodeCaptureInterface
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
        $handle = $this->getAttribute('handle');

        if($this->hasAttribute('parent')) {
            $parentNode = $this->getAttribute('parent');
            if ($parentNode instanceof LayoutNode) {
                $templateName = $parentNode->getTemplateName();
                $compiler
                    ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->trackHandlerWithFileName('$templateName', '$handle')")
                    ->raw(";\n");
            }
        }

        if($efExtension->canAddPageLayout($handle)) {
            $efExtension->addPageLayout($handle);
            $compiler
                ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addPageLayout('$handle')")
                ->raw(";\n");

            /** @var PageLayout $pageLayout */
            $pageLayout = $efExtension->getPageLayout();
            $pageLayoutContents = $this->_minifySource($pageLayout->getPageLayoutContents($handle));

            // Prepare layout file to be parsed by the LayoutNode
            $source = new Source($pageLayoutContents, $handle);

            $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));

            $compiler->subcompile($nodes->getNode('body'));
        }
    }
}