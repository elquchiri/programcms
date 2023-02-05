<?php


namespace ElectroForums\CoreBundle\Model\Provider;


class TimeZoneSelector implements \ElectroForums\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        $timezone_identifiers = \DateTimeZone::listIdentifiers();

        return $timezone_identifiers;
    }
}