<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CoreBundle\View\Element;


use Twig\Environment;

class Template extends AbstractBlock
{
    /**
     * Path to template file.
     *
     * @var string
     */
    protected $_template;
    /**
     * Assigned variables for view
     *
     * @var array
     */
    protected $_viewVars = [];
    /**
     * Twig Environment instance
     * @var Environment
     */
    protected Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

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
    public function setTemplate($template)
    {
        $this->_template = $template;
        return $this;
    }

    public function getTemplate()
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
        // Parse name (@ElectroForumsTheme) file and pick from theme first, else from bundle
        return $this->_template;
    }

    /**
     * Assign variable
     *
     * @param   string|array $key
     * @param   mixed $value
     * @return  $this
     */
    public function assign($key, $value = null)
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
    public function fetchView($template)
    {
        try {
            return $this->environment->render($template, $this->_viewVars);
        } catch (\Exception $e) {

        }
    }
}