<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Helper;

/**
 * Class State
 * @package ProgramCms\CoreBundle\Helper
 */
class State extends AbstractHelper
{

    const ENV_RUN_CODE = 'PROGRAMCMS_RUN_CODE';

    const ENV_RUN_TYPE = 'PROGRAMCMS_RUN_TYPE';

    const DEFAULT_RUN_CODE = 'base';

    const DEFAULT_RUN_TYPE = 'website';
}