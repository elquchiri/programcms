<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DeleteUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class DeleteUserButton implements ButtonProviderInterface
{
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * DeleteUserButton constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '',
            'label' => $this->translator->trans('Delete User'),
            'confirm' => [
                'title' => $this->translator->trans('You are about to Delete a User'),
                'text' => '<div class="text-muted p-0 m-0"><p class="p-0 m-0">'. $this->translator->trans('Please note that this action is irreversible, all other attached entities will also be definitively deleted.') . '<p class="m-0 p-0">'. $this->translator->trans('Anonymization can be a good solution, this will completely encode user\'s data and helps keeping it in the database.') . '</p></p>',
                'yes' => $this->translator->trans('Delete User'),
                'no' => $this->translator->trans('Cancel')
            ]
        ];
    }
}