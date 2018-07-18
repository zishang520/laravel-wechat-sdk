<?php
namespace luoyy\Wechat;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use luoyy\Wechat\Wechat;

class WechatManager extends Wechat
{
    /**
     * log overwrite
     * @see Wechat::log()
     */
    protected function log($log)
    {
        if ($this->debug) {
            if (function_exists($this->logcallback)) {
                if (is_array($log)) {
                    $log = print_r($log, true);
                }
                return call_user_func($this->logcallback, $log);
            } elseif (class_exists('Log')) {
                Log::debug('wechat：' . $log);
                return true;
            }
        }
        return false;
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired)
    {
        return Cache::put($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename)
    {
        return Cache::get($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename)
    {
        return Cache::forget($cachename);
    }
}
