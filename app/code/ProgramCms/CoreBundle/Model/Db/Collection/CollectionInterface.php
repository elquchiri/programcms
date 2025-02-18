<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Collection;

/**
 * Helps implementing new Collection Type
 * Interface CollectionInterface
 * @package ProgramCms\CoreBundle\Model\Db\Collection
 */
interface CollectionInterface
{

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return string
     */
    public function getEntity(): string;
}