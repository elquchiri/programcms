<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Ui\Grid\Column;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class ThemeActions
 * @package ProgramCms\ThemeBundle\Ui\Grid\Column
 */
class ThemeActions extends \ProgramCms\UiBundle\Component\Listing\ActionsColumn
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
            foreach($dataSourceData as $rowData) {
                $actions = [
                    [
                        'label' => 'Visualize',
                        'url' => $this->url->getUrlByRouteName('theme_index_view', ['id' => $rowData->getThemeId()]),
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