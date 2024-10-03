<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Command;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\Theme\AbstractTheme;
use ProgramCms\ThemeBundle\Entity\Theme;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ReflectionException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpgradeThemes
 * @package ProgramCms\ThemeBundle\Command
 */
#[AsCommand(
    name: 'theme:upgrade',
    aliases: ['th:up'],
    hidden: false
)]
class UpgradeThemes extends Command
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * UpgradeThemes constructor.
     * @param BundleManager $bundleManager
     * @param ThemeRepository $themeRepository
     * @param ObjectManager $objectManager
     * @param string|null $name
     */
    public function __construct(
        BundleManager $bundleManager,
        ThemeRepository $themeRepository,
        ObjectManager $objectManager,
        string $name = null
    )
    {
        parent::__construct($name);
        $this->bundleManager = $bundleManager;
        $this->themeRepository = $themeRepository;
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this->setDescription('')
            ->setHelp('');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $themes = $this->bundleManager->getAllThemes();
        //dd($themes);
        foreach($themes as $themePath => $theme) {
            if(!$this->themeRepository->getByThemePath($themePath)) {
                /** @var AbstractTheme $themeObject */
                $themeObject = new $theme['class'];
                if($themeObject) {
                    $themeEntity = new Theme();
                    $parentPath = $themeObject->getParent();
                    $themeEntity
                        ->setArea($themeObject->getArea())
                        ->setCode(str_replace('/', '_', $themeObject->getShortPath()))
                        ->setThemeTitle($themeObject->getName())
                        ->setThemePath($themeObject->getShortPath());
                    if(!empty($parentPath)) {
                        /** @var Theme $parentTheme */
                        $parentTheme = $this->themeRepository->getByThemePath($parentPath);
                        $themeEntity->setParent($parentTheme);
                    }
                    $this->themeRepository->save($themeEntity);
                }
            }
        }
        $output->writeln('data patches completed successfully.');
        return Command::SUCCESS;
    }
}