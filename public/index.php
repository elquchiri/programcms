<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

use ProgramCms\CoreBundle\App\Kernel;

/* PHP version validation */
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 80100) {
    echo <<<HTML
<div style="font:12px/1.35em arial, helvetica, sans-serif;">
    <p>ProgramCMS supports PHP 8.1.0 or later. Please read ProgramCMS System Requirements
</div>
HTML;
    exit(1);
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
