<?php

return [
    'token' => env('WECHAT_TOKEN', ''), //填写你设定的key
    'encodingaeskey' => env('WECHAT_ENCODING_AES_KEY', ''), //填写加密用的EncodingAESKey
    'appid' => env('WECHAT_APPID', ''), //填写高级调用功能的app id
    'appsecret' => env('WECHAT_APPSECRET', ''), //填写高级调用功能的密钥
    'debug' => env('WECHAT_DEBUG', false) //填写高级调用功能的密钥
];
