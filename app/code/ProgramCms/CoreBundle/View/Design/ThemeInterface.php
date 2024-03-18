<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design;

/**
 * Class ThemeInterface
 * @package ProgramCms\CoreBundle\View\Design
 */
interface ThemeInterface
{
    /**
     * @return string|null
     */
    public function getArea(): ?string;

    /**
     * @param string $area
     * @return $this
     */
    public function setArea(string $area): static;

    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self;

    /**
     * @return ThemeInterface|null
     */
    public function getParent(): ?ThemeInterface;

    /**
     * @return string
     */
    public function getParentThemeTitle(): string;

    /**
     * @return mixed
     */
    public function hasParent();

    /**
     * @return string|null
     */
    public function getThemeTitle(): ?string;

    /**
     * @return string|null
     */
    public function getThemePath(): ?string;

    /**
     * @return string|null
     */
    public function getPreviewImage(): ?string;
}