<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

/**
 * Class Hidden
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class Hidden extends \ProgramCms\UiBundle\Block\Form\Fields\Field
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/hidden.html.twig";

}