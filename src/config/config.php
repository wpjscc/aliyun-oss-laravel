<?php

return [
    'driver' => 'aliyun',
    'accessId' => env('ALIYUN_OSS_ACCESS_ID'),
    'accessKey' => env('ALIYUN_OSS_ACCESS_KEY'),
    'bucket' => env('ALIYUN_OSS_BUCKET'),
    'endpoint' => env('ALIYUN_OSS_ENDPOINT', 'oss-cn-shanghai.aliyuncs.com'),
    'endpointInternal' => env('ALIYUN_OSS_ENDPOINT_INTERNAL', ''),
    'isCname' => env('ALIYUN_OSS_IS_CNAME', false),
    'cdnDomain' => env('ALIYUN_OSS_CDN_DOMAIN', ''),
    'ssl' => env('ALIYUN_OSS_SSL', false),
    'debug' => env('ALIYUN_OSS_DEBUG', false),
    'securityToken' => env('ALIYUN_OSS_TOKEN', null),
    'prefix' => env('ALIYUN_OSS_PREFIX', null),
    'options'=> [],
];
