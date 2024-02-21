<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Node;

/**
 * Class FieldNode
 * @package ProgramCms\UiBundle\Twig\Node
 */
class FieldNode extends AbstractNodeComponent implements \Twig\Node\NodeCaptureInterface
{

    protected function _configuration(): array
    {
        return [];
    }
}