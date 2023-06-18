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
    private \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    private \ProgramCms\RouterBundle\Service\Request $request;
    protected Environment $environment;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        $this->directoryList = $context->getDirectoryList();
        $this->request = $context->getRequest();
        $this->environment = $context->getEnvironment();
        // Assign efBlock variable helping accessing block object from template.
        $this->assign(['efBlock' => $this]);
    }

    /**
     * @throws \Exception
     */
    protected function _toHtml(): string
    {
        if (!$this->getTemplate()) {
            return '';
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
     *
     * @param string $fileName
     * @return string
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