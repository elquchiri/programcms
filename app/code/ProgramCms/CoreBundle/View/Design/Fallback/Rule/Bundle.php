<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;

/**
 * Class Bundle
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
class Bundle implements RuleInterface
{
    /**
     * @var RuleInterface
     */
    protected RuleInterface $rule;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * Bundle constructor.
     * @param RuleInterface $rule
     * @param BundleManager $bundleManager
     */
    public function __construct(
        RuleInterface $rule,
        BundleManager $bundleManager
    )
    {
        $this->rule = $rule;
        $this->bundleManager = $bundleManager;
    }

    /**
     * @param array $params
     * @return array|mixed
     */
    public function getPatternDirs(array $params)
    {
        if (!array_key_exists('bundle_name', $params)) {
            throw new \InvalidArgumentException(
                'Required parameter "bundle_name" is not defined.'
            );
        }
        $params['bundle_dir'] = $this->bundleManager->getPath(
            BundleManager::BUNDLE,
            $params['bundle_name']
        );
        if (empty($params['bundle_dir'])) {
            return [];
        }
        return $this->rule->getPatternDirs($params);
    }
}