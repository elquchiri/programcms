<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Node;

use ProgramCms\ThemeBundle\Model\PageLayout;
use ReflectionException;
use Twig\Compiler;
use Twig\Error\SyntaxError;
use Twig\Source;

/**
 * Class FieldsetNode
 * @package ProgramCms\UiBundle\Twig\Node
 */
class FieldsetNode extends AbstractNodeComponent implements \Twig\Node\NodeCaptureInterface
{

    protected function _configuration(): array
    {
        return [];
    }
}