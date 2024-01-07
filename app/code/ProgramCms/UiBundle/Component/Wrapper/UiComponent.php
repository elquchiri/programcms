<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Wrapper;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\UiBundle\View\Element\ContainerInterface;
use ProgramCms\UiBundle\View\Element\UiComponentInterface;

/**
 * Class UiComponent
 * @package ProgramCms\UiBundle\Component\Wrapper
 */
class UiComponent extends Template implements ContainerInterface
{
    /**
     * @var UiComponentInterface
     */
    protected UiComponentInterface $component;

    /**
     * UiComponent constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        foreach ($this->getChildNames() as $childName) {
            $childBlock = $this->getLayout()->getBlock($childName);
            if ($childBlock) {
//                $wrapper = $this->blockWrapperFactory->create([
//                    'block' => $childBlock,
//                    'data' => [
//                        'name' => 'block_' . $childName
//                    ]
//                ]);
//                $this->component->addComponent('block_' . $childName, $wrapper);
            }
        }

        return $this->component->toHtml();
    }
}