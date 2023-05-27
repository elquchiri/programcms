<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


/**
 * Class EFLayoutNode
 * EFLayouts contains only EFContainers and EFReferenceContainers
 * @package ElectroForums\ThemeBundle\Node
 */
class EFLayoutNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    public function __construct($body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
    }

    public function compile(\Twig\Compiler $compiler)
    {
        // Retrieve the template file
        $templateName = $this->getTemplateName();

        foreach($this->getNode('body') as $node) {
            switch ($node) {
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode):
                    // Add root container
                    $containerName = $node->getAttribute('containerName');
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->addEfRootContainer('$containerName')")
                        ->raw(";\n");
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->trackElementWithFileName('$templateName', '$containerName')")
                        ->raw(";\n");
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFReferenceContainerNode):
                    foreach ($node->getNode('body') as $subContainerNode) {
                        if ($subContainerNode instanceof \ElectroForums\ThemeBundle\Node\EFContainerNode) {
                            $subContainerName = $subContainerNode->getAttribute('containerName');
                            $compiler
                                ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->trackElementWithFileName('$templateName', '$subContainerName')")
                                ->raw(";\n");
                        }
                    }
                    break;
                case ($node instanceof \ElectroForums\ThemeBundle\Node\EFUpdateNode):
                    $handlerName = $node->getAttribute('handle');
                    $compiler
                        ->write("\$this->env->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension')->trackHandlerWithFileName('$templateName', '$handlerName');");
                    break;
            }
        }

        $compiler->subcompile($this->getNode('body'));
    }
}