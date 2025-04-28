<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Loader;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\FileSystem;
use ProgramCms\CoreBundle\View\Layout;
use ProgramCms\RouterBundle\Service\Request;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;

/**
 * Class LayoutLoader
 * @package ProgramCms\ThemeBundle\Loader
 */
class LayoutLoader
{
    const DEFAULT_LAYOUT_FILE = 'default.yaml';

    /**
     * @var FileSystem
     */
    protected FileSystem $fileSystem;

    /**
     * @var Layout
     */
    protected Layout $layout;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var BundleManager
     */
    private BundleManager $bundleManager;

    /**
     * @var array
     */
    private array $paths = [];

    /**
     * @var string
     */
    private string $currentPageLayout;

    /**
     * LayoutLoader constructor.
     * @param BundleManager $bundleManager
     * @param Request $request
     * @param FileSystem $fileSystem
     * @param Layout $layout
     */
    public function __construct(
        BundleManager $bundleManager,
        Request $request,
        FileSystem $fileSystem,
        Layout $layout
    )
    {
        $this->bundleManager = $bundleManager;
        $this->request = $request;
        $this->fileSystem = $fileSystem;
        $this->layout = $layout;
    }

    /**
     * @param $layoutName
     * @return array
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    private function _initLayoutPaths($layoutName)
    {
        $areaCode = $this->request->getCurrentAreaCode();

        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $params = ['bundle' => $bundle['name']];
            if ($areaCode) {
                $params['area'] = $areaCode;
            }
            // Get the configuration file path for the bundle
            $defaults = $this->fileSystem->getLayoutFileName(self::DEFAULT_LAYOUT_FILE, $params);
            $layouts = $this->fileSystem->getLayoutFileName($layoutName, $params);

            if (!empty($defaults)) {
                foreach ($defaults as $default) {
                    $this->paths['default'][] = $default;
                }
            }
            if (!empty($layouts)) {
                foreach ($layouts as $layout) {
                    $this->paths['layout'][] = $layout;
                }
            }
        }

        if(!isset($this->paths['layout'])) {
            throw new \Exception(sprintf('No Layout %s found !', $layoutName));
        }

        return array_merge($this->paths['default'], $this->paths['layout']);
    }

    /**
     * @param string $name
     * @return void
     * @throws ReflectionException|InvalidArgumentException
     */
    public function renderLayout(string $name): void
    {
        // Parse and populate current layout paths
        $finalLayoutParser = $this->_initLayoutPaths($name);
        foreach ($finalLayoutParser as $layoutFile) {
            $currentLayoutParser = \Symfony\Component\Yaml\Yaml::parseFile($layoutFile);
            $this->prepareLayout($currentLayoutParser);
        }
    }

    /**
     * @param $layoutParser
     * @throws \Exception
     */
    public function prepareLayout($layoutParser)
    {
        if ($layoutParser) {
            if (isset($layoutParser['layout'])) {
                $this->currentPageLayout = $layoutParser['layout'];
                $this->layout->setCurrentPageLayout($this->currentPageLayout);
                $this->parseRequire($layoutParser['layout']);
            }

            if (isset($layoutParser['removes'])) {
                $this->parseRemoves($layoutParser['removes']);
            }

            if (isset($layoutParser['moves'])) {
                $this->parseMoves($layoutParser['moves']);
            }

            $this->prepareElement($layoutParser);
        }
    }

    /**
     * @param array $parser
     * @param string $parent
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function prepareElement(array $parser, string $parent = ''): void
    {
        foreach ($parser as $parseKey => $parseValue) {
            if (in_array($parseKey, ['require', 'layout', 'removes', 'moves'])) {
                continue;
            }

            if ($parseKey === 'requires') {
                foreach ($parser['requires'] as $parserRequire) {
                    $this->parseRequires($parserRequire);
                }
                continue;
            }

            if ($parseKey === 'referenceContainers') {
                foreach ($parser['referenceContainers'] as $referenceKey => $referenceData) {
                    if (!$this->layout->getStructure()->hasElement($referenceKey)) {
                        continue;
                    }

                    if (isset($referenceData['blocks'])) {
                        foreach ($referenceData['blocks'] as $blockKey => $block) {
                            $this->layout->addBlock(
                                $blockKey,
                                $block['class'],
                                $block['template'] ?? '',
                                $referenceKey,
                                $block['before'] ?? '',
                                $block['after'] ?? '',
                                isset($block['arguments']) ? json_encode($block['arguments']) : ''
                            );
                            if (isset($block['blocks'])) {
                                $this->processNestedBlocks($block['blocks'], $blockKey);
                            }
                        }
                    }

                    if (isset($referenceData['containers'])) {
                        foreach ($referenceData['containers'] as $containerKey => $container) {
                            $this->prepareElement([$containerKey => $container], $referenceKey);
                        }
                    }

                    if(isset($referenceData['htmlTag'])) {
                        $this->layout->overrideAttribute($referenceKey, 'htmlTag', $referenceData['htmlTag']);
                    }
                    if(isset($referenceData['htmlClass'])) {
                        $this->layout->overrideAttribute($referenceKey, 'htmlClass', $referenceData['htmlClass']);
                    }
                    if(isset($referenceData['htmlId'])) {
                        $this->layout->overrideAttribute($referenceKey, 'htmlId', $referenceData['htmlId']);
                    }
                }
                continue;
            }

            if ($parseKey === 'referenceBlocks') {
                foreach ($parser['referenceBlocks'] as $referenceKey => $referenceData) {
                    if (!$this->layout->getStructure()->hasElement($referenceKey)) {
                        continue;
                    }

                    if (isset($referenceData['blocks'])) {
                        foreach ($referenceData['blocks'] as $blockKey => $block) {
                            $this->layout->addBlock(
                                $blockKey,
                                $block['class'],
                                $block['template'] ?? '',
                                $referenceKey,
                                $block['before'] ?? '',
                                $block['after'] ?? '',
                                isset($block['arguments']) ? json_encode($block['arguments']) : ''
                            );

                            if (isset($block['blocks'])) {
                                $this->processNestedBlocks($block['blocks'], $blockKey);
                            }
                        }
                    }
                }
                continue;
            }

            $this->layout->addContainer(
                $parseKey,
                $parent,
                $parseValue['htmlTag'] ?? '',
                $parseValue['htmlClass'] ?? '',
                $parseValue['htmlId'] ?? '',
                $parseValue['before'] ?? '',
                $parseValue['after'] ?? '',
            );
            $this->layout->trackElementWithFileName($this->currentPageLayout, $parseKey);

            if (isset($parseValue['blocks'])) {
                foreach ($parseValue['blocks'] as $blockKey => $block) {
                    $this->layout->addBlock(
                        $blockKey,
                        $block['class'],
                        $block['template'] ?? '',
                        $parseKey,
                        $block['before'] ?? '',
                        $block['after'] ?? '',
                        isset($block['arguments']) ? json_encode($block['arguments']) : ''
                    );
                }
            }

            if (isset($parseValue['containers'])) {
                foreach ($parseValue['containers'] as $childKey => $childContainer) {
                    $this->prepareElement([$childKey => $childContainer], $parseKey);
                }
            }
        }
    }

    /**
     * @param $layoutName
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function parseRequires($layoutName)
    {
        foreach ($this->bundleManager->getAllBundles() as $bundle) {
            $areaCode = $this->request->getCurrentAreaCode();
            $params = ['bundle' => $bundle['name']];
            if ($areaCode) {
                $params['area'] = $areaCode;
            }

            $pageLayouts = $this->fileSystem->getLayoutFileName($layoutName . ".yaml", $params);
            foreach ($pageLayouts as $pageLayout) {
                $currentLayoutParser = \Symfony\Component\Yaml\Yaml::parseFile($pageLayout);
                $this->prepareLayout($currentLayoutParser);
            }
        }
    }

    /**
     * Process nested blocks recursively
     *
     * @param array $nestedBlocks
     * @param string $parentKey
     */
    private function processNestedBlocks(array $nestedBlocks, string $parentKey): void
    {
        foreach ($nestedBlocks as $blockKey => $block) {
            $this->layout->addBlock(
                $blockKey,
                $block['class'],
                $block['template'] ?? '',
                $parentKey,
                $block['before'] ?? '',
                $block['after'] ?? '',
                isset($block['arguments']) ? json_encode($block['arguments']) : ''
            );

            // If there are more nested blocks, call recursively
            if (isset($block['blocks'])) {
                $this->processNestedBlocks($block['blocks'], $blockKey);
            }
        }
    }

    public function parseRequire($layoutName)
    {
        if ($this->layout->canAddPageLayout($layoutName)) {
            $this->layout->addPageLayout($layoutName);

            foreach ($this->bundleManager->getAllBundles() as $bundle) {
                $areaCode = $this->request->getCurrentAreaCode();
                $params = ['bundle' => $bundle['name']];
                if ($areaCode) {
                    $params['area'] = $areaCode;
                }

                $pageLayouts = $this->fileSystem->getPageLayoutFileName($layoutName . ".yaml", $params);
                foreach ($pageLayouts as $pageLayout) {
                    $currentLayoutParser = \Symfony\Component\Yaml\Yaml::parseFile($pageLayout);
                    if (isset($currentLayoutParser['require'])) {
                        $this->currentPageLayout = $currentLayoutParser['require'];
                        $this->parseRequire($currentLayoutParser['require']);
                        $this->layout->trackHandlerWithFileName($layoutName, $this->currentPageLayout);
                    }

                    $this->currentPageLayout = $layoutName;
                    $this->prepareLayout($currentLayoutParser);
                }
            }
        }
    }

    /**
     * @param array $removals
     * @throws \Exception
     */
    public function parseRemoves(array $removals): void
    {
        foreach ($removals as $name) {
            if ($this->layout->getStructure()->hasElement($name)) {
                $this->layout->addElementToRemove($name);
            }
        }
    }

    public function parseMoves(array $moves): void
    {
        foreach ($moves as $name => $properties) {
            if ($this->layout->getStructure()->hasElement($name)) {
                $this->layout->addElementToMove(
                    $name,
                    $properties['destination'],
                    $properties['before'] ?? '',
                    $properties['after'] ?? ''
                );
            }
        }
    }
}