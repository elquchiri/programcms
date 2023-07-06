<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Layout;

/**
 * Class Element
 * @package ProgramCms\CoreBundle\View\Layout
 */
class Element
{
    const TYPE_BLOCK = 'block';
    const TYPE_CONTAINER = 'container';

    const CONTAINER_OPT_HTML_TAG = 'htmlTag';
    const CONTAINER_OPT_HTML_CLASS = 'htmlClass';
    const CONTAINER_OPT_HTML_ID = 'htmlId';
}