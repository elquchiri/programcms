<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

use Exception;
use ProgramCms\CoreBundle\Helper\Language;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\CoreBundle\View\Page\Config;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\LocaleSwitcher;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Page
 * @package ProgramCms\CoreBundle\View\Result
 */
class Page extends Layout
{
    /**
     * @var Config
     */
    protected Config $pageConfig;

    /**
     * @var Environment
     */
    protected Environment $env;

    /**
     * @var LocaleSwitcher
     */
    protected LocaleSwitcher $localeSwitcher;

    /**
     * @var Language
     */
    protected Language $language;

    /**
     * Page constructor.
     * @param Context $context
     * @param string $currentLayout
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct(
        Context $context,
        $currentLayout = ''
    )
    {
        parent::__construct($context, $currentLayout);
        $this->pageConfig = $context->getPageConfig();
        $this->env = $context->getEnvironment();
        $this->localeSwitcher = $context->getLocaleSwitcher();
        $this->language = $context->getLanguageHelper();
        $this->currentLayout = $currentLayout;
    }

    /**
     * Get Page Configuration
     */
    public function getConfig(): Config
    {
        return $this->pageConfig;
    }

    /**
     * Merge base template and render Page
     * @param array $parameters
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function render(array $parameters = []): Response
    {
        $layout = $this->getLayout();
        $html = $layout->getOutput();
        $locale = $this->localeSwitcher->getLocale();
        $dir = $this->language->getDir($locale);

        $content = $this->env->render('@ProgramCmsTheme/base.html.twig', [
            'dir' => $dir,
            'lang' => $locale,
            'html' => $html
        ]);

        $response ??= new Response();
        if (200 === $response->getStatusCode()) {
            foreach ($parameters as $v) {
                if ($v instanceof FormInterface && $v->isSubmitted() && !$v->isValid()) {
                    $response->setStatusCode(422);
                    break;
                }
            }
        }
        $response->setContent($content);
        return $response;
    }
}