<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    ElectroForums\UserBundle\ElectroForumsUserBundle::class => ['all' => true],
    ElectroForums\ThemeBundle\ElectroForumsThemeBundle::class => ['all' => true],
    ElectroForums\RouterBundle\ElectroForumsRouterBundle::class => ['all' => true],
    ElectroForums\AdminBundle\ElectroForumsAdminBundle::class => ['all' => true],
    ElectroForums\CmsBundle\ElectroForumsCmsBundle::class => ['all' => true],
    ElectroForums\ForumBundle\ElectroForumsForumBundle::class => ['all' => true],
    ElectroForums\ContentBundle\ElectroForumsContentBundle::class => ['all' => true],
    ElectroForums\PostBundle\ElectroForumsPostBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true],
    SymfonyCasts\Bundle\VerifyEmail\SymfonyCastsVerifyEmailBundle::class => ['all' => true],
];
