# Aliyun-oss-storage for Laravel

[![Latest Stable Version](https://poser.pugx.org/alphasnow/aliyun-oss-laravel/v/stable)](https://packagist.org/packages/alphasnow/aliyun-oss-laravel)
[![License](https://poser.pugx.org/alphasnow/aliyun-oss-laravel/license)](https://packagist.org/packages/alphasnow/aliyun-oss-laravel)
[![Build Status](https://travis-ci.com/alphasnow/aliyun-oss-laravel.svg?branch=master)](https://travis-ci.com/alphasnow/aliyun-oss-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-laravel/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-laravel/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alphasnow/aliyun-oss-laravel/?branch=master)

扩展借鉴了一些优秀的代码，综合各方，同时做了更多优化，将会添加更多完善的接口和插件，打造Laravel最好的OSS Storage扩展

## 运行环境
- PHP 7.0+
- cURL extension
- Laravel 5.5+

## 安装方法
1. 如果您通过composer管理您的项目依赖，可以在你的项目根目录运行：

        $ composer require alphasnow/aliyun-oss-laravel

   或者在你的`composer.json`中声明依赖：

        "require": {
            "alphasnow/aliyun-oss-laravel": "~2.0"
        }

2. 修改环境文件`.env`
    ```
    ALIYUN_OSS_ACCESS_ID=
    ALIYUN_OSS_ACCESS_KEY=
    ALIYUN_OSS_BUCKET=
    ALIYUN_OSS_ENDPOINT=oss-cn-shanghai.aliyuncs.com
    ALIYUN_OSS_IS_CNAME=false
    ALIYUN_OSS_CDN_DOMAIN=
    ALIYUN_OSS_SSL=false
    ```

3. (可选)修改配置文件 `config/filesystems.php`
    ```
    'default' => env('FILESYSTEM_DRIVER', 'aliyun'),
    // ...
    'disks'=>[
        // ...
        'aliyun' => [
            'driver'     => 'aliyun',
            'access_id'  => env('ALIYUN_OSS_ACCESS_ID'),
            'access_key' => env('ALIYUN_OSS_ACCESS_KEY'),
            'bucket'     => env('ALIYUN_OSS_BUCKET'),
            'endpoint'   => env('ALIYUN_OSS_ENDPOINT', 'oss-cn-shanghai.aliyuncs.com'),
            'is_cname'   => env('ALIYUN_OSS_IS_CNAME', false),
            'cdn_domain' => env('ALIYUN_OSS_CDN_DOMAIN', ''),
            'is_ssl'     => env('ALIYUN_OSS_IS_SSL', false),
        ],
        // ...
    ]
    ```

## 快速使用
```php
use Illuminate\Support\Facades\Storage;
$storage = Storage::disk('aliyun');
```
#### 文件写入
```php
Storage::disk('aliyun')->putFile('prefix/path', '/local/path/file.txt');
Storage::disk('aliyun')->putFileAs('prefix/path', '/local/path/file.txt', 'file.txt');

Storage::disk('aliyun')->put('prefix/path/file.txt', file_get_contents('/local/path/file.txt'));
$fp = fopen('/local/path/file.txt','r');
Storage::disk('aliyun')->put('prefix/path/file.txt', $fp);
fclose($fp);

Storage::disk('aliyun')->putRemoteFile('prefix/path/file.txt', 'http://example.com/file.txt');

Storage::disk('aliyun')->prepend('prefix/path/file.txt', 'Prepend Text'); 
Storage::disk('aliyun')->append('prefix/path/file.txt', 'Append Text');
```

#### 文件查询
```php
Storage::disk('aliyun')->url('prefix/path/file.txt');
Storage::disk('aliyun')->temporaryUrl('prefix/path/file.txt', \Carbon\Carbon::now()->addMinutes(30));

Storage::disk('aliyun')->get('prefix/path/file.txt'); 

Storage::disk('aliyun')->exists('prefix/path/file.txt'); 
Storage::disk('aliyun')->size('prefix/path/file.txt'); 
Storage::disk('aliyun')->lastModified('prefix/path/file.txt');
```

#### 文件操作
```php
Storage::disk('aliyun')->copy('prefix/path/file.txt', 'prefix/path/file_new.txt');
Storage::disk('aliyun')->move('prefix/path/file.txt', 'prefix/path/file_new.txt');
Storage::disk('aliyun')->rename('prefix/path/file.txt', 'prefix/path/file_new.txt');
```

#### 文件删除
```php
Storage::disk('aliyun')->delete('prefix/path/file.txt');
Storage::disk('aliyun')->delete(['prefix/path/file1.txt', 'prefix/path/file2.txt']);
```

#### 文件夹操作
```php
Storage::disk('aliyun')->makeDirectory('prefix/path'); 
Storage::disk('aliyun')->deleteDirectory('prefix/path');

// 查询一级子目录文件
Storage::disk('aliyun')->files('prefix/path');
// 递归查询多级子目录文件
Storage::disk('aliyun')->allFiles('prefix/path');

// 查询一级子目录
Storage::disk('aliyun')->directories('prefix/path'); 
// 递归查询多级子目录
Storage::disk('aliyun')->allDirectories('prefix/path'); 
```

> [阿里云OSS文档](https://help.aliyun.com/document_detail/32099.html?spm=5176.doc31981.6.335.eqQ9dM)

## 主要参考
- [jacobcyl/ali-oss-storage](https://github.com/jacobcyl/Aliyun-oss-storage)
- [overtrue/flysystem-qiniu](https://github.com/overtrue/flysystem-qiniu)

## License
See [LICENSE](LICENSE).