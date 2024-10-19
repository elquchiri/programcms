<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Security;

use ProgramCms\RouterBundle\Service\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Class AccessDeniedHandler
 * @package ProgramCms\AclBundle\Security
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    protected Url $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * @param Request $request
     * @param AccessDeniedException $accessDeniedException
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return new RedirectResponse($this->url->getUrlByRouteName('admin_index_index'));
    }
}