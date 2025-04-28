<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\Enum;

enum ReactionType: string
{
    case LIKE = 'like';
    case DISLIKE = 'dislike';
}