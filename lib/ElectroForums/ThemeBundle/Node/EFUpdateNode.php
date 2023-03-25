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

class EFUpdateNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    protected Environment $environment;

    public function __construct(Environment $environment, $handle, $lineno, $tag = null)
    {
        parent::__construct([], ['handle' => $handle], $lineno, $tag);
        $this->environment = $environment;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $efExtension = $this->environment->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension');
        $handle = $this->getAttribute('handle');

        $pageLayoutContents = $efExtension->getPageLayout()->getPageLayoutContents($handle);

        $source = new Source($pageLayoutContents, 'LayoutHandler');
        $nodes = $this->environment->parse($this->environment->tokenize($source));

        $compiler->subcompile($nodes->getNode('body'));
    }
}