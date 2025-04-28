<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element;

use Exception;
use ProgramCms\CoreBundle\App\State;
use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\View\Page\Config;
use ProgramCms\RouterBundle\Service\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Template
 * @package ProgramCms\CoreBundle\View\Element
 */
class Template extends AbstractBlock
{
    /**
     * Path to template file.
     * @var string
     */
    protected string $_template;

    /**
     * @var BlockInterface
     */
    protected BlockInterface $templateContext;

    /**
     * Assigned variables for view
     * @var array
     */
    protected array $viewVars = [];

    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Environment
     */
    protected Environment $environment;

    /**
     * @var Config
     */
    protected Config $pageConfig;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var Template\File\Resolver
     */
    protected Template\File\Resolver $resolver;

    /**
     * @var State
     */
    protected State $state;

    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

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
        $this->translator = $context->getTranslator();
        $this->transformer = $context->getTransformer();
        $this->resolver = $context->getResolver();
        $this->state = $context->getState();
        $this->templateContext = $this;
        parent::__construct($context, $data);
    }

    /**
     * Internal constructor, that is called from real constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        /*
         * In case template was passed through constructor
         * we assign it to block's property _template
         * Mainly for those cases when block created
         */
        if ($this->hasData('template')) {
            $this->setTemplate($this->getData('template'));
        }
    }

    /**
     * Set Template Context
     * @param $templateContext
     */
    public function setTemplateContext($templateContext)
    {
        $this->templateContext = $templateContext;
    }

    /**
     * @throws Exception
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

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->_template;
    }

    /**
     * @return bool
     */
    public function hasTemplate(): bool
    {
        return isset($this->_template);
    }

    /**
     * @return mixed|string|null
     */
    public function getArea()
    {
        return $this->_getData('area') ? $this->_getData('area') : $this->state->getAreaCode();
    }

    /**
     * @param string $area
     * @return $this
     */
    public function setArea(string $area): static
    {
        $this->setData('area', $area);
        return $this;
    }

    /**
     * Get absolute path to template
     * @param null $template
     * @return string
     * @throws Exception
     */
    public function getTemplateFile($template = null): string
    {
        $template = $template ?: $this->getTemplate();
        $params = ['bundle' => $this->getBundleName($template)];
        $area = $this->getArea();
        if ($area) {
            $params['area'] = $area;
        }
        return $this->resolver->getTemplateFileName($template, $params);
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
            $this->viewVars[$key] = $value;
        }
        return $this;
    }

    /**
     * Render block view from file (template)
     * @param $template
     * @return string
     * @throws LoaderError
     * @throws SyntaxError
     */
    public function fetchView($template): string
    {
        try {
            // Assign block variable helping accessing block object from template.
            if(empty($this->viewVars)) {
                $this->assign(['block' => $this->templateContext]);
            }

            return $this->environment
                ->createTemplate(
                    file_get_contents($template),
                    $template
                )
                ->render($this->viewVars);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param string $message
     * @param mixed ...$params
     * @return string
     */
    public function trans(string $message, ...$params): string
    {
        return isset($params) && !empty($params)
                ? sprintf($this->translator->trans($message), ...$params)
                : $this->translator->trans($message);
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function timeAgo(\DateTime $dateTime): string
    {
        return $this->transformer->timeAgo($dateTime);
    }
}