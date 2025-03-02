<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Structure;

use ProgramCms\ConfigBundle\App\Context;
use ProgramCms\ConfigBundle\App\ScopeConfigInterface;
use ProgramCms\ConfigBundle\Model\StructureElementInterface;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AbstractElement
 * @package ProgramCms\ConfigBundle\Model\Structure
 */
abstract class AbstractElement implements StructureElementInterface
{
    /**
     * @var array
     */
    protected array $_data = [];

    /**
     * @var mixed
     */
    protected $_scope;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $_translator;

    /**
     * AbstractElement constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        $this->_translator = $context->getTranslator();
    }

    /**
     * @param $code
     * @return string
     */
    protected function _getTranslatedAttribute($code)
    {
        if (false == array_key_exists($code, $this->_data)) {
            return '';
        }
        return $this->_translator->trans($this->_data[$code]);
    }

    /**
     * @param array $data
     * @param $scope
     */
    public function setData(array $data, $scope)
    {
        $this->_data = $data;
        $this->_scope = $scope;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key): mixed
    {
        return array_key_exists($key, $this->_data) ? $this->_data[$key] : null;
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->_data['name'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->_data['id'] ?? '';
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->_getTranslatedAttribute('label');
    }

    /**
     * @return mixed|string
     */
    public function getType()
    {
        return $this->_data['type'] ?? 'text';
    }

    /**
     * @return string
     */
    public function getHelpMessage()
    {
        return $this->_getTranslatedAttribute('helpMessage');
    }

    /**
     * @return mixed|string
     */
    public function getFrontendModel()
    {
        return $this->_data['frontend_model'] ?? '';
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        $showInScope = [
            ScopeInterface::SCOPE_WEBSITE_VIEW => $this->_hasVisibilityValue('website_view'),
            ScopeInterface::SCOPE_WEBSITE => $this->_hasVisibilityValue('website'),
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT => $this->_hasVisibilityValue('default'),
        ];

        return !empty($showInScope[$this->_scope]);
    }

    /**
     * @param $key
     * @return bool
     */
    protected function _hasVisibilityValue($key)
    {
        return isset($this->_data['scope']) && in_array($key, $this->_data['scope']);
    }

    /**
     * @param string $fieldPrefix
     * @return mixed|string
     */
    public function getPath($fieldPrefix = '')
    {
        return $this->_data['path'] ?? '';
    }
}