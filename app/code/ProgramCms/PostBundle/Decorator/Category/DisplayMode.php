<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Decorator\Category;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\MapDecorated;
use \ProgramCms\PostBundle\Helper\Data as PostDataHelper;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DisplayMode
 * @package ProgramCms\PostBundle\Decorator\Category
 */
#[AsDecorator(
    decorates: \ProgramCms\CatalogBundle\Model\Provider\DataSource\DisplayMode::class,
    priority: 10
)]
class DisplayMode
{
    /**
     * @var \ProgramCms\CatalogBundle\Model\Provider\DataSource\DisplayMode
     */
    protected \ProgramCms\CatalogBundle\Model\Provider\DataSource\DisplayMode $subject;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * DisplayMode constructor.
     * @param \ProgramCms\CatalogBundle\Model\Provider\DataSource\DisplayMode $subject
     * @param TranslatorInterface $translator
     */
    public function __construct(
        #[MapDecorated] \ProgramCms\CatalogBundle\Model\Provider\DataSource\DisplayMode $subject,
        TranslatorInterface $translator
    )
    {
        $this->subject = $subject;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        return array_merge(
            $this->subject->getOptionsArray(),
            [
                PostDataHelper::CATEGORY_POST_DISPLAY_MODE => $this->translator->trans("Categories and Posts"),
                PostDataHelper::POST_DISPLAY_MODE => $this->translator->trans("Only Posts")
            ]
        );
    }
}