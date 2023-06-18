<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;


abstract class Options implements \ProgramCms\UiBundle\Model\Provider\DataSource\OptionsInterface
{
    abstract public function getOptionsArray(): array;
}