<?php


namespace ElectroForums\UserBundle\Model\Provider;


class AccountSharingOptions implements \ElectroForums\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        return [
            'Global', 'Per Website'
        ];
    }
}