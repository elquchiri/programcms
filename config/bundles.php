<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    ProgramCms\CoreBundle\ProgramCmsCoreBundle::class => ['all' => true],
    ProgramCms\EavBundle\ProgramCmsEavBundle::class => ['all' => true],
    ProgramCms\ThemeBundle\ProgramCmsThemeBundle::class => ['all' => true],
    ProgramCms\UiBundle\ProgramCmsUiBundle::class => ['all' => true],
    ProgramCms\RouterBundle\ProgramCmsRouterBundle::class => ['all' => true],
    ProgramCms\AdminBundle\ProgramCmsAdminBundle::class => ['all' => true],
    ProgramCms\ConfigBundle\ProgramCmsConfigBundle::class => ['all' => true],
    ProgramCms\WebsiteBundle\ProgramCmsWebsiteBundle::class => ['all' => true],
    ProgramCms\CmsBundle\ProgramCmsCmsBundle::class => ['all' => true],
    ProgramCms\ContentBundle\ProgramCmsContentBundle::class => ['all' => true],
    ProgramCms\CatalogBundle\ProgramCmsCatalogBundle::class => ['all' => true],
    ProgramCms\PostBundle\ProgramCmsPostBundle::class => ['all' => true],
    ProgramCms\UserBundle\ProgramCmsUserBundle::class => ['all' => true],
    ProgramCms\ForumBundle\ProgramCmsForumBundle::class => ['all' => true],
    ProgramCms\ContactBundle\ProgramCmsContactBundle::class => ['all' => true],
    ProgramCms\NewsletterBundle\ProgramCmsNewsletterBundle::class => ['all' => true],
    ProgramCms\SearchBundle\ProgramCmsSearchBundle::class => ['all' => true],
    ProgramCms\CommentBundle\ProgramCmsCommentBundle::class => ['all' => true],
    ProgramCms\ReportBundle\ProgramCmsReportBundle::class => ['all' => true],
    ProgramCms\ManagerBundle\ProgramCmsManagerBundle::class => ['all' => true],
    ProgramCms\NotificationBundle\ProgramCmsNotificationBundle::class => ['all' => true],
    ProgramCms\MessagingBundle\ProgramCmsMessagingBundle::class => ['all' => true],
    ProgramCms\AdminNotificationBundle\ProgramCmsAdminNotificationBundle::class => ['all' => true],
    ProgramCms\SecurityBundle\ProgramCmsSecurityBundle::class => ['all' => true],
    ProgramCms\AiBundle\ProgramCmsAiBundle::class => ['all' => true],
    ProgramCms\ImportBundle\ProgramCmsImportBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle::class => ['all' => true],
    Symfony\UX\TwigComponent\TwigComponentBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
];
