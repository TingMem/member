<?php
return array(
	//'配置项'=>'配置值'
	//'SESSION_AUTO_START' => true, //是否开启session
	
	
        'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => 'localhost', // 服务器地址
        'DB_NAME'   => 'member', // 数据库名
//Test
    'DB_USER'   => 'root', // 用户名
//         'DB_USER'   => 'root', // 用户名
        'DB_PWD'    => 'liang123', // 密码
//         'DB_PWD'    => '142536', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => 'tp_', // 数据库表前缀 
		'SHOW_PAGE_TRACE' =>true, 
		
		'TOKEN_ON'      =>    false,  // 是否开启令牌验证 默认关闭
	    'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	    'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	    'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
	
);
