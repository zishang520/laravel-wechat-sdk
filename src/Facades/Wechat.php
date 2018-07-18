<?php
namespace luoyy\Wechat\Facades;

use Illuminate\Support\Facades\Facade;
use luoyy\Wechat\WechatManager;

/**
 */
class Wechat extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return WechatManager::class;
    }
}
