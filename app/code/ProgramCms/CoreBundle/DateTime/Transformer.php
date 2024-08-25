<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\DateTime;

use DateTime;
use ProgramCms\CoreBundle\App\Config;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Transformer
 * @package ProgramCms\CoreBundle\DateTime
 */
class Transformer implements TransformerInterface
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * Transformer constructor.
     * @param Config $config
     * @param TranslatorInterface $translator
     */
    public function __construct(
        Config $config,
        TranslatorInterface $translator
    )
    {
        $this->config = $config;
        $this->translator = $translator;
    }

    /**
     * @param DateTime $dateTime
     * @param string $format
     * @return string
     */
    public function transform(DateTime $dateTime, string $format = self::DEFAULT_FORMAT): string
    {
        $timezone = $this->config->getValue(self::TIMEZONE_CONFIG_PATH, ScopeInterface::SCOPE_WEBSITE_VIEW);
        $dateTimeString = new DateTimeToStringTransformer($timezone, $timezone, $format, null);
        return $dateTimeString->transform($dateTime);
    }

    /**
     * @param DateTime $dateTime
     * @return string
     */
    public function timeAgo(DateTime $dateTime): string
    {
        $now = new DateTime();
        $diff = $now->diff($dateTime);

        if ($diff->y > 0) {
            return sprintf(
                $this->translator->trans("%s year%s ago"),
                $diff->y, ($diff->y > 1 ? 's' : '')
            );
        }
        if ($diff->m > 0) {
            if($diff->m == 1) {
                return $this->translator->trans("one month ago");
            }elseif($diff->m == 2) {
                return $this->translator->trans("two months ago");
            }else if($diff->m > 2 && $diff->m <= 10) {
                return sprintf(
                    $this->translator->trans("%s months ago"),
                    $diff->m
                );
            }else if($diff->m > 10) {
                return sprintf(
                    $this->translator->trans("%s month ago"),
                    $diff->m
                );
            }
        }
        if ($diff->d > 0) {
            if($diff->d == 1) {
                return $this->translator->trans("one day ago");
            }elseif($diff->d == 2) {
                return $this->translator->trans("two days ago");
            }else if($diff->d > 2 && $diff->d <= 10) {
                return sprintf(
                    $this->translator->trans("%s days ago"),
                    $diff->d
                );
            }else if($diff->d > 10) {
                return sprintf(
                    $this->translator->trans("%s day ago"),
                    $diff->d
                );
            }
            return sprintf($this->translator->trans("%s day%s ago"), $diff->d, ($diff->d > 1 ? 's' : ''));
        }
        if ($diff->h > 0) {
            return sprintf($this->translator->trans("%s hour%s ago"), $diff->h, ($diff->h > 1 ? 's' : ''));
        }
        if ($diff->i > 0) {
            return sprintf($this->translator->trans("%s minute%s ago"), $diff->i, ($diff->i > 1 ? 's' : ''));
        }
        if ($diff->s > 0) {
            return sprintf($this->translator->trans("%s second%s ago"), $diff->s, ($diff->s > 1 ? 's' : ''));
        }

        return $this->translator->trans('just now');
    }
}