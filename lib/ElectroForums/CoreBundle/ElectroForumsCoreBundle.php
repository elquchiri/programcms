<?php


namespace ElectroForums\CoreBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElectroForumsCoreBundle extends Bundle
{
    public const VERSION = '1.0.0';

    /**
     * Define bundle as ElectroForums Bundle Type
     * @return bool
     */
    public function isElectroForumsBundle()
    {
        return true;
    }
}