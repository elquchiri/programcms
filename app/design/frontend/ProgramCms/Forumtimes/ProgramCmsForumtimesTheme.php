<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\Forumtimes;

use ProgramCms\CoreBundle\Theme\Theme;

/**
 * Class ProgramCmsForumtimesTheme
 * @package ProgramCms\Forumtimes
 */
class ProgramCmsForumtimesTheme extends Theme
{
    /**
     * @var string
     */
    protected string $name = 'ProgramCMS ForumTimes Theme';

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "This is the ProgramCMS ForumTimes Frontend Theme";
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return [
            'name' => "Mohamed EL QUCHIRI",
            'email' => 'elquchiri@gmail.com'
        ];
    }
}