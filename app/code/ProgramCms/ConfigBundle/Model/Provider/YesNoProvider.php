<?php


namespace ProgramCms\ConfigBundle\Model\Provider;


class YesNoProvider implements \ProgramCms\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        return [
            '0' => 'No',
            '1' => 'Yes'
        ];
    }
}