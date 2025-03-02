<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Ui\Listing\Column;

use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\Component\Listing\ActionsColumn;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;

/**
 * Class UserAddressActions
 * @package ProgramCms\UserBundle\Ui\Listing\Column
 */
class UserAddressActions extends ActionsColumn
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * ThemeActions constructor.
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
            /** @var UserAddressEntity $rowData */
            foreach($dataSourceData as $rowData) {
                $actions = [
                    [
                        'label' => 'Edit',
                        'url' => $this->url->getUrlByRouteName('user_address_edit', [
                            'id' => $rowData->getEntityId(),
                            'user' => $rowData->getUser()->getEntityId()
                        ]),
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