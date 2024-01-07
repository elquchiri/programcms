<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
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
     */
    public function getDataSourceData()
    {
        $data = [];
        if ($this->hasData('dataSource')) {
            /** @var AbstractDataProvider $dataProvider */
            $dataProvider = $this->getContext()->getDataProvider();
            $data = $dataProvider->getData();

            // Filter Provided Data by primaryFieldName
            $primaryFieldName = $dataProvider->getPrimaryFieldName();
            $requestFieldName = $dataProvider->getRequestFieldName();
            if (!empty($requestFieldName)) {
                $entityId = (int)$this->request->getParam($requestFieldName);
                if (!empty($entityId)) {
                    $data = $dataProvider
                        ->getCollection()
                        ->filter(function ($entity) use ($entityId, $primaryFieldName) {
                            return $entity->getDataUsingMethod($primaryFieldName) === $entityId;
                        })
                        ->toArray();
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