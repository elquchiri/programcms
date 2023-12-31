<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Node;

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
     * @throws SyntaxError|ReflectionException
     */
    protected function _compile(Compiler &$compiler)
    {
        $efExtension = $compiler->getEnvironment()->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout();
        $handle = $this->getAttribute('handle');

        if($this->hasAttribute('parent')) {
            $parentNode = $this->getAttribute('parent');
            $templateName = $parentNode->getTemplateName();
        }else{
            $templateName = '';
        }
        $compiler
            ->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->trackHandlerWithFileName('$templateName', '$handle');");


        if($efExtension->canAddPageLayout($handle)) {
            $efExtension->addPageLayout($handle);
            $compiler->write("\$this->env->getExtension('\ProgramCms\ThemeBundle\Extension\ThemeExtension')->getLayout()->addPageLayout('$handle');");


            /** @var \ProgramCms\ThemeBundle\Model\PageLayout $pageLayout */
            $pageLayout = $efExtension->getPageLayout();
            $pageLayoutContents = $pageLayout->getPageLayoutContents($handle);

            // Prepare layout file to be parsed by the LayoutNode
            $source = new Source($pageLayoutContents, $handle);

            $nodes = $compiler->getEnvironment()->parse($compiler->getEnvironment()->tokenize($source));

            $compiler->subcompile($nodes->getNode('body'));
        }
    }
}