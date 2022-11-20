<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    // \think\middleware\SessionInit::class
    // 拦截和过滤 HTTP 请求，并进行相应处理
    // \app\middleware\Check::class
    // 允许跨域
    // 默认跨域中间件
    // AllowCrossDomain::class
    // 自定义跨域中间件
    // AllowCrossDomainMiddleware::class
    // 处理请求头中间件,这里注释掉是考虑到登录时没有token无法通过中间件
    // app\middleware\compareToken::class
];
