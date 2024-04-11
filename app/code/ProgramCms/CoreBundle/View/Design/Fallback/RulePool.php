<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback;

use InvalidArgumentException;
use ProgramCms\CoreBundle\View\Design\Fallback\Rule\Composite;
use ReflectionException;

/**
 * Class RoolPool
 * @package ProgramCms\CoreBundle\View\Design\Fallback
 */
class RulePool
{
    const TYPE_FILE = 'file';

    const TYPE_TEMPLATE_FILE = 'template';

    const TYPE_PAGE_LAYOUT_FILE = 'page_layout';

    const TYPE_LAYOUT_FILE = 'layout';

    const TYPE_ASSET_FILE = 'asset';

    const TYPE_SCSS_ASSET_FILE = 'scss';

    /**
     * @var ModularSwitchFactory
     */
    protected ModularSwitchFactory $modularSwitchFactory;

    /**
     * @var ThemeFactory
     */
    protected ThemeFactory $themeFactory;

    /**
     * @var SimpleFactory
     */
    protected SimpleFactory $simpleFactory;

    /**
     * @var BundleFactory
     */
    protected BundleFactory $bundleFactory;

    /**
     * @var array
     */
    private array $rules = [];

    /**
     * RulePool constructor.
     * @param ModularSwitchFactory $modularSwitchFactory
     * @param ThemeFactory $themeFactory
     * @param SimpleFactory $simpleFactory
     * @param BundleFactory $bundleFactory
     */
    public function __construct(
        ModularSwitchFactory $modularSwitchFactory,
        ThemeFactory $themeFactory,
        SimpleFactory $simpleFactory,
        BundleFactory $bundleFactory
    )
    {
        $this->modularSwitchFactory = $modularSwitchFactory;
        $this->themeFactory = $themeFactory;
        $this->simpleFactory = $simpleFactory;
        $this->bundleFactory = $bundleFactory;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createTemplateFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/templates"])
            ]),
            'ruleModular' => new Composite([
                $this->themeFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>/templates"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>/templates"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base/templates"])
                ]),
            ])
        ]);
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createPageLayoutFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/page_layout"])
            ]),
            'ruleModular' => new Composite([
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>/page_layout"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base/page_layout"])
                ]),
                $this->themeFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>/page_layout"])
                ])
            ])
        ]);
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createLayoutFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/layout"])
            ]),
            'ruleModular' => new Composite([
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>/layout"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base/layout"])
                ]),
                $this->themeFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>/layout"])
                ])
            ])
        ]);
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>"])
            ]),
            'ruleModular' => new Composite([
                $this->themeFactory->create(
                    ['rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>"])]
                ),
                $this->bundleFactory->create(
                    ['rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>"])]
                ),
                $this->bundleFactory->create(
                    ['rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base"])]
                ),
            ])
        ]);
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createAssetFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/assets"])
            ]),
            'ruleModular' => new Composite([
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>/assets"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base/assets"])
                ]),
                $this->themeFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>/assets"])
                ])
            ])
        ]);
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    protected function createScssAssetFileRule(): ?object
    {
        return $this->modularSwitchFactory->create([
            'ruleNonModular' => $this->themeFactory->create([
                'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/assets/css/source"])
            ]),
            'ruleModular' => new Composite([
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/<area>/assets/css/source"])
                ]),
                $this->bundleFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<bundle_dir>/Resources/views/base/assets/css/source"])
                ]),
                $this->themeFactory->create([
                    'rule' => $this->simpleFactory->create(['pattern' => "<theme_dir>/<bundle_name>/assets/css/source"])
                ])
            ])
        ]);
    }

    /**
     * @param $type
     * @return mixed
     * @throws ReflectionException
     */
    public function getRule($type)
    {
        if (isset($this->rules[$type])) {
            return $this->rules[$type];
        }
        $rule = match ($type) {
            self::TYPE_FILE => $this->createFileRule(),
            self::TYPE_TEMPLATE_FILE => $this->createTemplateFileRule(),
            self::TYPE_PAGE_LAYOUT_FILE => $this->createPageLayoutFileRule(),
            self::TYPE_LAYOUT_FILE => $this->createLayoutFileRule(),
            self::TYPE_ASSET_FILE => $this->createAssetFileRule(),
            self::TYPE_SCSS_ASSET_FILE => $this->createScssAssetFileRule(),
            default => throw new InvalidArgumentException("Fallback rule '$type' is not supported"),
        };
        $this->rules[$type] = $rule;
        return $this->rules[$type];
    }
}