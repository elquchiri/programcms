<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Legal;

/**
 * Class Copyright
 * @package ProgramCms\AdminBundle\Block\Legal
 */
class SiteUpdate extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * Returns site update phrase
     * Little code that doesn't do much
     * Just a desire to keep the two phrases
     * @return string
     */
    public function getUpdatePhrase(): string
    {
        $phrases = ["You're using the latest version", "This Site is Up-to-Date"];
        return $phrases[array_rand($phrases)];
    }
}