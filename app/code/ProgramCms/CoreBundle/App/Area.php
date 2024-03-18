<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use ProgramCms\CoreBundle\View\DesignInterface;

/**
 * Class Area
 * @package ProgramCms\CoreBundle\App
 */
class Area implements AreaInterface
{
    /**
     * @var DesignInterface
     */
    protected DesignInterface $design;

    /**
     * @var array
     */
    protected array $loadedParts;

    /**
     * @var string
     */
    protected string $areaCode;

    /**
     * Area constructor.
     * @param DesignInterface $design
     * @param string $areaCode
     */
    public function __construct(
        DesignInterface $design,
        string $areaCode = ''
    )
    {
        $this->design = $design;
        $this->areaCode = $areaCode;
    }

    /**
     * @param null $part
     * @return void
     */
    public function load($part = null)
    {
        if ($part === null) {
            $this->loadPart(AreaInterface::PART_DESIGN);
        } else {
            $this->loadPart($part);
        }
    }

    /**
     * @param string $part
     * @return $this
     */
    protected function loadPart(string $part): static
    {
        if (isset($this->loadedParts[$part])) {
            return $this;
        }

        switch ($part) {
            case self::PART_DESIGN:
                $this->initDesign();
                break;
        }
        $this->loadedParts[$part] = true;
        return $this;
    }

    /**
     * @return $this
     */
    protected function initDesign(): static
    {
        $this->design->setDefaultDesignTheme();
        return $this;
    }
}