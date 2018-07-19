<?php
namespace luoyy\Wechat\Providers;

use Illuminate\Support\ServiceProvider;
use luoyy\Wechat\WechatManager;

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
        $this->app->singleton(WechatManager::class, function ($app) {
            // 载入配置
            $app->configure('wechat');
            $config = $app->make('config')->get('wechat') ?: (require __DIR__ . '/../config/wechat.php');
            return new WechatManager($config);
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
            WechatManager::class
        ];
    }
}
