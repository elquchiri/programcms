<?php


namespace ProgramCms\CoreBundle\Model\Provider;


class TimeZoneSelector implements \ProgramCms\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        $timezone_identifiers = \DateTimeZone::listIdentifiers();

        return $timezone_identifiers;
    }
}