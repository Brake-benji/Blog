<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_ACTION_ERROR'     =>  APP_PATH.'Backend/message.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  APP_PATH.'Backend/message.html', // 默认成功跳转对应的模板文件
    //数据库配置信息
    'DB_TYPE'               => 'mysql', // 数据库类型
    'DB_HOST'               => '127.0.0.1', // 服务器地址
    'DB_NAME'               => 'blog', // 数据库名
    'DB_USER'               => 'root', // 用户名
    'DB_PWD'                => '', // 密码
    'DB_PORT'               =>  3306, // 端口
    'DB_CHARSET'            =>  'utf8', // 字符集
    'DATA_CACHE_TIME'       =>  600,
    'URL_MODEL'             =>  2,

    'SHOW_PAGE_TRACE'       => false,
    '__STATIC__'            => 'http://localhost:88/Blog',
);