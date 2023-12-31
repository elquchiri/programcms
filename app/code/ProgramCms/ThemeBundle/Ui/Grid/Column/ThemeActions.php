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
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        foreach($dataSource as &$rowData) {
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
        return $dataSource;
    }
}