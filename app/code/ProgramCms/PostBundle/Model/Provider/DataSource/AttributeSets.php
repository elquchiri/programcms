<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Provider\DataSource;

use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Repository\EavAttributeSetRepository;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;

/**
 * Class AttributeSets
 * @package ProgramCms\PostBundle\Model\Provider\DataSource
 */
class AttributeSets extends Options
{
    /**
     * @var EavAttributeSetRepository
     */
    protected EavAttributeSetRepository $eavAttributeSetRepository;

    /**
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $eavEntityTypeRepository;

    /**
     * AttributeSets constructor.
     * @param EavEntityTypeRepository $eavEntityTypeRepository
     * @param EavAttributeSetRepository $eavAttributeSetRepository
     */
    public function __construct(
        EavEntityTypeRepository $eavEntityTypeRepository,
        EavAttributeSetRepository $eavAttributeSetRepository
    )
    {
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $sets = [];
        $entityType = $this->eavEntityTypeRepository->getByTypeCode(PostEntity::class);
        $attributeSets = $this->eavAttributeSetRepository->findBy(
            ['entityType' => $entityType]
        );
        /** @var EavAttributeSet $attributeSet */
        foreach($attributeSets as $attributeSet) {
            $sets[$attributeSet->getAttributeSetId()] = $attributeSet->getAttributeSetName();
        }
        return $sets;
    }
}