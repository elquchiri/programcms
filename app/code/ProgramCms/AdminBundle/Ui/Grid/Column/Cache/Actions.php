<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Ui\Grid\Column\Cache;

use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\Component\Listing\ActionsColumn;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Actions
 * @package ProgramCms\AdminBundle\Ui\Grid\Column\Cache
 */
class Actions extends ActionsColumn
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Actions constructor.
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
            foreach($dataSourceData as $rowData) {
                $actions = [
                    [
                        'label' => 'Clear Cache',
                        'url' => $this->url->getUrlByRouteName('user_index_edit', ['id' => $rowData->getEntityId()]),
                        'type' => 'url'
                    ],
                    [
                        'label' => 'Disable',
                        'url' => $this->url->getUrlByRouteName('user_index_edit', ['id' => $rowData->getEntityId()]),
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