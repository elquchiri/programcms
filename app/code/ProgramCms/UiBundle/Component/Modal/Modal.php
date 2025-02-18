<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Modal;

use Exception;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\Component\Form\Element\AbstractElement;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Modal
 * @package ProgramCms\UiBundle\Component\Modal
 */
class Modal extends AbstractElement
{
    const NAME = 'modal';

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * Field constructor.
     * @param Context $context
     * @param ObjectSerializer $objectSerializer
     * @param array $data
     */
    public function __construct(
        Context $context,
        ObjectSerializer $objectSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectSerializer = $objectSerializer;
    }

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/modal/modal.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}