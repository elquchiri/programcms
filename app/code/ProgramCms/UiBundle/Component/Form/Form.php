<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use Exception;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Form
 * @package ProgramCms\UiBundle\Block\Form
 */
class Form extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'form';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/form.html.twig";

    /**
     * Form constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getDataSourceData()
    {
        $data = [];
        $formName = $this->getNameInLayout();

        if ($this->hasData('dataSource')) {
            $dataProvider = $this->getContext()->getDataProvider($formName);
            $data = $dataProvider->getData();

            // Filter Provided Data by primaryFieldName
            $primaryFieldName = $dataProvider->getPrimaryFieldName();
            $requestFieldName = $dataProvider->getRequestFieldName();
            if (!empty($requestFieldName)) {
                $entityId = (int)$this->request->getParam($requestFieldName);
                if (!empty($entityId)) {
                    $data = $dataProvider
                        ->getCollection()
                        ->addFieldToFilter($primaryFieldName, $entityId)
                        ->getData();
                }
            }

        }
        return $data;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        $dataSource = $this->getData('dataSource');
        return isset($dataSource['settings']['submitUrl']) ?
            $this->getUrl($dataSource['settings']['submitUrl']) : '';
    }
}