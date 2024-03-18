<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

/**
 * Class ModularSwitch
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
class ModularSwitch implements RuleInterface
{
    /**
     * @var RuleInterface
     */
    protected RuleInterface $ruleNonModular;

    /**
     * @var RuleInterface
     */
    protected RuleInterface $ruleModular;

    /**
     * ModularSwitch constructor.
     * @param RuleInterface $ruleNonModular
     * @param RuleInterface $ruleModular
     */
    public function __construct(
        RuleInterface $ruleNonModular,
        RuleInterface $ruleModular
    )
    {
        $this->ruleNonModular = $ruleNonModular;
        $this->ruleModular = $ruleModular;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPatternDirs(array $params)
    {
        if (isset($params['bundle_name'])) {
            return $this->ruleModular->getPatternDirs($params);
        } else {
            return $this->ruleNonModular->getPatternDirs($params);
        }
    }
}