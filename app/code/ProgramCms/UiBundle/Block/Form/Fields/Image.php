<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class Image
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class Image extends \ProgramCms\UiBundle\Block\Form\Fields\Field
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/image.html.twig";
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Image constructor.
     * @param Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->url = $url;
    }

    /**
     * Prepare Image source path
     * @return string
     */
    public function getSrc(): string
    {
        return $this->getValue() ?? '';
    }

}