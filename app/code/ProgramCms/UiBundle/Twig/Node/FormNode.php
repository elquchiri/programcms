<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Twig\Node;

/**
 * Class FormNode
 * @package ProgramCms\UiBundle\Twig\Node
 */
class FormNode extends AbstractNodeComponent implements \Twig\Node\NodeCaptureInterface
{
    /**
     * @return array
     */
    protected function _configuration(): array
    {
        return [
            'class' => \ProgramCms\UiBundle\Component\Form\Form::class,
            'template' => '@ProgramCmsUiBundle/form/form.html.twig',
            'data-controller' => 'some-controller'
        ];
    }
}