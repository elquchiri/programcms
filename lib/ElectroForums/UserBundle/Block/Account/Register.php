<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Block\Account;


use Twig\Environment;

class Register extends \ElectroForums\CoreBundle\View\Element\Template
{

    public function __construct(Environment $environment)
    {
        parent::__construct($environment);
    }
}