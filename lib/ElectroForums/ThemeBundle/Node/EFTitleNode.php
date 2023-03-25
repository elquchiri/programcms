<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ThemeBundle\Node;


use Twig\Environment;

class EFTitleNode extends \Twig\Node\Node implements \Twig\Node\NodeCaptureInterface
{
    protected Environment $environment;

    public function __construct(Environment $environment, $body, $lineno, $tag = null)
    {
        parent::__construct(['body' => $body], [], $lineno, $tag);
        $this->environment = $environment;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function compile(\Twig\Compiler $compiler)
    {
        $efExtension = $this->environment->getExtension('\ElectroForums\ThemeBundle\Extension\EFThemeExtension');
        $efExtension->setEfTitle($this->getNode('body')->getAttribute('data'));
    }
}