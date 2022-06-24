<?php

namespace AlphaSnow\AliyunOss;

use AlphaSnow\Flysystem\AliyunOss\Plugins\AppendContent;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use League\Flysystem\Config as FlysystemConfig;
use League\Flysystem\Filesystem;
use OSS\OssClient;

/**
 * Class ServiceProvider
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return void
     */
    public function boot()
    {
        $this->app->make('filesystem')
            ->extend('aliyun', function ($app, array $config) {
                return $app->make('aliyun-oss.oss-filesystem', $config);
            });
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->bind('aliyun-oss.oss-client', function ($app, array $config) {
            $ossConfig = new Config($config);

            $client = $app->make(OssClient::class, $ossConfig->getOssClientParameters());
            $client->setUseSSL($ossConfig->get('use_ssl', false));
            return $client;
        });

        $this->app->bind('aliyun-oss.oss-adapter', function ($app, array $config) {
            $client = $app->make('aliyun-oss.oss-client', $config);

            return new Adapter($client, new Config($config));
        });

        $this->app->bind('aliyun-oss.oss-filesystem', function ($app, array $config) {
            $adapter = $app->make('aliyun-oss.oss-adapter', $config);

            $filesystem = new Filesystem($adapter, new FlysystemConfig(['disable_asserts' => true]));
            $filesystem->addPlugin(new AppendContent());
            return $filesystem;
        });
    }

    protected function registerConfig()
    {
        if ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached()) {
            return;
        }

        $config = $this->app->make('config');
        $disks = $config->get("filesystems.disks", []);
        $drivers = array_column($disks, "driver");
        if (in_array("aliyun", $drivers)) {
            return;
        }

        $config->set("filesystems.disks.aliyun", array_merge(
            require __DIR__ . "/config/config.php",
            $config->get("filesystems.disks.aliyun", [])
        ));
    }
}
