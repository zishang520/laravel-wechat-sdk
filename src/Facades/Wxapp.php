<?php
namespace luoyy\Wechat\Facades;

use Illuminate\Support\Facades\Facade;
use luoyy\Wechat\WxappManager;

/**
 */
class Wxapp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return WxappManager::class;
    }
}
