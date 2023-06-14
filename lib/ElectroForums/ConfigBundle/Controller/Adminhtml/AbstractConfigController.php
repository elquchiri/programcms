<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Controller\Adminhtml;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractConfigController
 * @package ElectroForums\ConfigBundle\Controller\Adminhtml
 */
abstract class AbstractConfigController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{
    protected function loadConfigurations(): Response
    {
        return $this->getResponse()->render();
    }
}