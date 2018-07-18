<?php
namespace luoyy\Wechat\Providers;

use Illuminate\Support\ServiceProvider;
use luoyy\Wechat\WechatManager;
use luoyy\Wechat\WxappManager;

class WechatServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WxappManager::class, function (&$app) {
            $config = $app->make('config')->get('cache');
            var_dump($config);
            return new WxappManager();
        });
        $this->app->singleton(WechatManager::class, function (&$app) {
            return new WechatManager();
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            WxappManager::class,
            WechatManager::class
        ];
    }
}
