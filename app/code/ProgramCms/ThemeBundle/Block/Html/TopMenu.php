<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Html;

use ProgramCms\CoreBundle\View\Element\Template;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class TopMenu
 * @package ProgramCms\ThemeBundle\Block\Html
 */
class TopMenu extends Template
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * TopMenu constructor.
     * @param Template\Context $context
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->security = $security;
    }

    /**
     * @return string
     */
    public function generateMenu(): string
    {
        $html = "";
        $items = $this->getChildBlocks();
        uasort($items, function ($firstItem, $secondItem) {
            return $firstItem->getData('sortOrder') <=> $secondItem->getData('sortOrder');
        });
        foreach($items as $child) {
            if($child->hasData('isAuth')) {
                if($child->getData('isAuth') == true) {
                    if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                        $html .= $child->toHtml();
                    }
                }else{
                    if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                        $html .= $child->toHtml();
                    }
                }
            }else {
                $html .= $child->toHtml();
            }
        }

        return $html;
    }
}