<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

use ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController;
use \ProgramCms\ConfigBundle\Model\ConfigSerializer;
use ProgramCms\ConfigBundle\Model\Config as ConfigModel;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SaveController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class SaveController extends AbstractConfigController
{
    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $config;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var ConfigModel
     */
    protected ConfigModel $configModel;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param ConfigSerializer $configSerializer
     * @param Url $url
     * @param TranslatorInterface $translator
     * @param ConfigModel $configModel
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        ConfigSerializer $configSerializer,
        Url $url,
        TranslatorInterface $translator,
        ConfigModel $configModel
    )
    {
        parent::__construct($context, $objectManager, $configSerializer, $url, $translator);
        $this->url = $url;
        $this->translator = $translator;
        $this->configModel = $configModel;
    }

    /**
     * @return mixed
     */
    protected function _getGroupsForSave()
    {
        $groups = $this->getRequest()->getCurrentRequest()->get('groups');
        $files = $this->getRequest()->getCurrentRequest()->files->get('groups');
        if ($files && is_array($files)) {
            // Merge $_FILES and $_POST data
            foreach ($files as $groupName => $group) {
                $data = $this->processNestedGroups($group);
                if (!empty($data)) {
                    if (!empty($groups[$groupName])) {
                        $groups[$groupName] = array_merge_recursive((array)$groups[$groupName], $data);
                    } else {
                        $groups[$groupName] = $data;
                    }
                }
            }
        }
        return $groups;
    }

    /**
     * @param array $group
     * @return array
     */
    protected function processNestedGroups(array $group)
    {
        $data = [];
        if (isset($group['fields']) && is_array($group['fields'])) {
            foreach ($group['fields'] as $fieldName => $field) {
                if (!empty($field['value'])) {
                    $data['fields'][$fieldName] = ['value' => $field['value']];
                }
            }
        }
        if (isset($group['groups']) && is_array($group['groups'])) {
            foreach ($group['groups'] as $groupName => $groupData) {
                $nestedGroup = $this->processNestedGroups($groupData);
                if (!empty($nestedGroup)) {
                    $data['groups'][$groupName] = $nestedGroup;
                }
            }
        }
        return $data;
    }

    /**
     * Save App Config
     * @return RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        $sectionId = $request->get('section');
        if($request->getMethod() == 'POST') {
            $section = $sectionId;
            $website = $request->get('website');
            $websiteView = $request->get('website_view');
            $configData = [
                'section' => $section,
                'website' => $website,
                'website_view' => $websiteView,
                'groups' => $this->_getGroupsForSave(),
            ];
            $this->configModel->setData($configData);
            $this->configModel->save();

            // Flash success message
            $this->addFlash('success',
                $this->translator->trans('Configuration successfully saved.')
            );

            return $this->redirect($this->url->getUrlByRouteName('config_systemconfig_edit', $this->redirectParams($request, $sectionId)));
        }
        // Flash error message
        $this->addFlash('danger',
            $this->trans('Error Saving Configuration Data, please try again.')
        );
        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }

    /**
     * @param $request
     * @param $sectionId
     * @return array
     */
    private function redirectParams($request, $sectionId)
    {
        // Scope Switcher Redirection
        $redirectParams = ['section' => $sectionId];
        $websiteSwitcher = $request->get('website');
        $websiteViewSwitcher = $request->get('website_view');
        if(!empty($websiteSwitcher)) {
            $redirectParams['website'] = $websiteSwitcher;
        }else if(!empty($websiteViewSwitcher)) {
            $redirectParams['website_view'] = $websiteViewSwitcher;
        }
        return $redirectParams;
    }
}