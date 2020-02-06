<?php

namespace Matteao\AliyunSms;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * 标记着提供器是延迟加载的
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 注册服务
     * 
     */
    public function register()
    {
        $this->app->singleton(AliyunSms::class, function ($app) {
            return new AliyunSms(
                config('services.aliyun_sms.key'),
                config('services.aliyun_sms.secret'),
                config('services.aliyun_sms.sign_name')
            );
        });
    }

    /**
     * 取得提供者提供的服务
     *
     * @return array
     */
    public function provides()
    {
        return [AliyunSms::class];
    }
}
