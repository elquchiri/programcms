<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\AdminBundle\Controller\Adminhtml\Dashboard;


class IndexController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        parent::__construct($request);
        $this->toolbar = $toolbar;
    }

    public function execute()
    {
        $this->toolbar->addButton("Reload Data", "", "primary");

        return $this->render('@ElectroForumsAdmin/adminhtml/home.html.twig', [
            'buttons' => $this->toolbar->getButtons()
        ]);
    }
}