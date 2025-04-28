<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Block;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\PageBundle\Repository\PageRepository;
use ProgramCms\UiBundle\View\Element\UiComponentFactory;

/**
 * Class PageEditor
 * @package ProgramCms\PageBundle\Block
 */
class PageEditor extends Template
{
    protected ObjectManager $objectManager;
    protected UiComponentFactory $uiComponentFactory;
    protected EntityManagerInterface $entityManager;

    public function __construct(
        Template\Context $context,
        ObjectManager $objectManager,
        UiComponentFactory $uiComponentFactory,
        EntityManagerInterface $entityManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $objectManager;
        $this->uiComponentFactory = $uiComponentFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    public function getLoadUrl(): string
    {
        return $this->getUrl('page_ajax_loadpage', [
            'page_id' => $this->getPageId()
        ]);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('page_index_save');
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->getRequest()->getParam('page_id');
    }

    /**
     * @return string
     */
    public function getBackIcon(): string
    {
        return '/bundles/programcmspage/images/back.png';
    }

    public function getRepository()
    {
        $entityClass = $this->getData('entity');
        return $eavEntityType = $this->entityManager
            ->getRepository($entityClass);
    }

    public function getEavAttributes()
    {
        $attrs = [];
        $layout = $this->getLayout();
        $requestedAttributes = $this->getData('attributes');
        $id = $this->getRequest()->getParam('id');
        $currentEntityObject = $this->getRepository()->getById($id);

        foreach ($requestedAttributes as $attributeCode) {
            /** @var EavAttribute $attribute */
            $attribute = $this->entityManager->getRepository(EavAttribute::class)->findOneBy(['attribute_code' => $attributeCode]);
            if($attribute) {
                $frontendInput = $attribute->getFrontendInput();
                $component = $this->uiComponentFactory->create(
                    $frontendInput,
                    $attribute->getAttributeCode(),
                    ['value' => $currentEntityObject->getData($attribute->getAttributeCode())],
                    $layout);
                $attrs[] = [
                    'name' => $attribute->getAttributeCode(),
                    'label' => $attribute->getFrontendLabel(),
                    'html' => $component->toHtml()
                ];
            }
        }

        return $attrs;
    }
}