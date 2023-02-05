<?php


namespace ElectroForums\ConfigBundle\Model\Provider;


class YesNoProvider implements \ElectroForums\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        return [
            '0' => 'No',
            '1' => 'Yes'
        ];
    }
}