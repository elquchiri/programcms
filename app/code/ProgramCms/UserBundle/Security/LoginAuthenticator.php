<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Security;

use ProgramCms\UserBundle\Helper\Config as UserConfigHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Class LoginAuthenticator
 * @package ProgramCms\UserBundle\Security
 */
class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    const LOGIN_ROUTE = 'frontend_user_account_login';

    /**
     * @var UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * @var UserConfigHelper
     */
    protected UserConfigHelper $userConfigHelper;

    /**
     * LoginAuthenticator constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param UserConfigHelper $userConfigHelper
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserConfigHelper $userConfigHelper
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->userConfigHelper = $userConfigHelper;
    }

    /**
     * @param Request $request
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $request->getSession()->set(Security::LAST_USERNAME, $email);
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge()
            ]
        );
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
        if($this->userConfigHelper->shouldRedirectUserAfterLogin()) {
            return new RedirectResponse($this->urlGenerator->generate('frontend_user_edit_index'));
        }
        return new RedirectResponse($this->urlGenerator->generate('frontend_cms_index_index'));
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
