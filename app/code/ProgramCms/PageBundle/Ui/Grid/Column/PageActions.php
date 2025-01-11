<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Ui\Grid\Column;

use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\Component\Listing\ActionsColumn;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class PageActions
 * @package ProgramCms\PageBundle\Ui\Grid\Column
 */
class PageActions extends ActionsColumn
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * PageActions constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $context->getTemplateContext()->getUrl();
    }

    /**
     * @return void
     */
    public function prepare()
    {
        parent::prepare();
        if($this->hasData('source')) {
            $dataSourceName = $this->getData('source');
            $dataSourceBlock = $this->getLayout()->getBlock($dataSourceName);
            $dataSourceData = $this->getContext()->getDataSourceData($dataSourceBlock);
            /** @var PageEntity $rowData */
            foreach($dataSourceData as $rowData) {
                $actions = [
                    [
                        'label' => 'Edit',
                        'url' => $this->url->getUrlByRouteName('page_index_edit', ['page_id' => $rowData->getEntityId()]),
                        'type' => 'url'
                    ],
                    [
                        'label' => 'Go To Page',
                        'url' => $this->url->getUrlByFullRouteName('frontend_page_index_view', ['id' => $rowData->getEntityId()]),
                        'type' => 'url'
                    ]
                ];
                $rowData->setDataUsingMethod(
                    $this->getName(),
                    $actions
                );
            }
        }
    }
}