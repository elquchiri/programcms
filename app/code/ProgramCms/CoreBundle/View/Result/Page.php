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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct(
        Context $context,
    )
    {
        parent::__construct($context);
        $this->pageConfig = $context->getPageConfig();
        $this->env = $context->getEnvironment();
        $this->localeSwitcher = $context->getLocaleSwitcher();
        $this->language = $context->getLanguageHelper();
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
        $css = $layout->getCss();
        $js = $layout->getJs();
        $title = $layout->getTitle();
        $html = $layout->getOutput();
        $locale = $this->localeSwitcher->getLocale();
        $dir = $this->language->getDir($locale);

        $theme = sprintf('app_backend_%s', $locale);
        $theme = 'app_backend_ar_MA';

        $content = $this->env->render('@ProgramCmsTheme/base.html.twig', [
            'dir' => $dir,
            'lang' => $locale,
            'theme' => $theme,
            'css' => $css,
            'js' => $js,
            'title' => $title,
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