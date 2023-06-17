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

    public function __construct(Environment $environment, array $data = [])
    {
        parent::__construct($environment, $data);
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
        $this->_template = $template;
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->_template;
    }

    /**
     * Get absolute path to template
     *
     * @param string|null $template
     * @return string|bool
     */
    public function getTemplateFile($template = null)
    {
        return $this->_template;
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