<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

use Twig\Environment;

/**
 * Class Template
 * @package ProgramCms\CoreBundle\View\Element
 */
class Template extends AbstractBlock
{
    /**
     * Path to template file.
     *
     * @var string
     */
    protected string $_template;
    /**
     * Assigned variables for view
     *
     * @var array
     */
    protected array $_viewVars = [];
    /**
     * @var \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList
     */
    protected \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    protected \ProgramCms\RouterBundle\Service\Request $request;
    /**
     * @var Environment
     */
    protected Environment $environment;
    /**
     * @var \ProgramCms\CoreBundle\View\Page\Config
     */
    protected \ProgramCms\CoreBundle\View\Page\Config $pageConfig;

    /**
     * Template constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->directoryList = $context->getDirectoryList();
        $this->request = $context->getRequest();
        $this->environment = $context->getEnvironment();
        $this->pageConfig = $context->getPageConfig();
    }

    /**
     * @throws \Exception
     */
    protected function _toHtml(): string
    {
        if (!$this->getTemplate()) {
            return '';
        }
        // Assign efBlock variable helping accessing block object from template.
        if(empty($this->_viewVars)) {
            $this->assign(['efBlock' => $this]);
        }
        return $this->fetchView($this->getTemplateFile());
    }

    /**
     * Set path to template used for generating block's output.
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template): static
    {
        if(!empty($template)) {
            $this->_template = $template;
        }
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->_template;
    }

    /**
     * Get absolute path to template
     *
     * @return string|bool
     */
    public function getTemplateFile(): string
    {
        $areaCode = $this->request->getCurrentAreaCode();
        $templateParts = explode('/', $this->getTemplate());
        $bundleName = explode('@', $templateParts[0])[1];
        unset($templateParts[0]);
        $requestedTemplatePath = implode('/', $templateParts);
        $templatePath = '@' . str_replace('Bundle', '', $bundleName) . '/' . $areaCode . '/templates/' . $requestedTemplatePath;
        $themeTemplatePath = $this->directoryList->getRoot() . '/app/design/' . $areaCode . '/ProgramCms/blank/' . $bundleName . '/templates/' . $requestedTemplatePath;

        return is_file($themeTemplatePath) ? '@Themes/' . $areaCode . '/ProgramCms/blank/' . $bundleName . '/templates/' .$requestedTemplatePath : $templatePath;
    }

    /**
     * Assign variable
     *
     * @param   string|array $key
     * @param   mixed $value
     * @return  $this
     */
    public function assign($key, $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $subKey => $subValue) {
                $this->assign($subKey, $subValue);
            }
        } else {
            $this->_viewVars[$key] = $value;
        }
        return $this;
    }

    /**
     * Retrieve block view from file (template)
     * @param $template
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function fetchView($template): string
    {
        try {
            return $this->environment->render($template, $this->_viewVars);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}