<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Ui\Listing\Column;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\Component\Listing\ActionsColumn;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class PostActions
 * @package ProgramCms\PostBundle\Ui\Listing\Column
 */
class PostActions extends ActionsColumn
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * PostActions constructor.
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
                        'label' => $this->trans('Edit'),
                        'url' => $this->url->getUrlByRouteName('post_index_edit', ['id' => $rowData->getEntityId()]),
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