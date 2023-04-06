<?php

declare(strict_types=1);

use Imi\App;
use Imi\AppContexts;

$mode = App::isInited() ? App::getApp()->getType() : null;

return [
    // 配置文件
    'configs'    => [
        'beans'        => __DIR__ . '/beans.php',
    ],

    'ignoreNamespace'   => [
    ],

    // 主服务器配置
    'mainServer'    => 'swoole' === $mode ? [
        'namespace'    => 'ImiApp\UDPServer',
        // @phpstan-ignore-next-line
        'type'         => Imi\Swoole\Server\Type::UDP_SERVER,
        'host'         => '0.0.0.0',
        'port'         => 8083,
        'configs'      => [
            // 'worker_num'        =>  8,
            // 'task_worker_num'   =>  16,
        ],
        // 数据处理器
        'dataParser'    => Imi\Server\DataParser\JsonObjectParser::class,
    ] : [],

    // 子服务器（端口监听）配置
    'subServers'        => [
        // 'SubServerName'   =>  [
        //     'namespace'    =>    'ImiApp\XXXServer',
        //     'type'        =>    Imi\Server\Type::HTTP,
        //     'host'        =>    '0.0.0.0',
        //     'port'        =>    13005,
        // ]
    ],

    // Workerman 服务器配置
    'workermanServer' => 'workerman' === $mode ? [
        'http' => [
            'namespace' => 'ImiApp\UDPServer',
            'type'      => Imi\Workerman\Server\Type::UDP,
            'host'      => '0.0.0.0',
            'port'      => 8083,
            'configs'   => [
            ],
        ],
    ] : [],

    // 连接池配置
    'pools'    => 'swoole' === $mode ? [
        // 主数据库
        'maindb'    => [
            'pool'    => [
                // @phpstan-ignore-next-line
                'class'        => \Imi\Swoole\Db\Pool\CoroutineDbPool::class,
                'config'       => [
                    'maxResources'              => 32,
                    'minResources'              => 0,
                    'checkStateWhenGetResource' => false,
                    'heartbeatInterval'         => 60,
                ],
            ],
            'resource'    => [
                'host'        => '127.0.0.1',
                'port'        => 3306,
                'username'    => 'root',
                'password'    => 'root',
                'database'    => 'mysql',
                'charset'     => 'utf8mb4',
            ],
        ],
        'redis'    => [
            'pool'    => [
                // @phpstan-ignore-next-line
                'class'        => \Imi\Swoole\Redis\Pool\CoroutineRedisPool::class,
                'config'       => [
                    'maxResources'              => 32,
                    'minResources'              => 0,
                    'checkStateWhenGetResource' => false,
                    'heartbeatInterval'         => 60,
                ],
            ],
            'resource'    => [
                'host'      => '127.0.0.1',
                'port'      => 6379,
                'password'  => null,
            ],
        ],
    ] : [],

    // 数据库配置
    'db'    => [
        // 数默认连接池名
        'defaultPool'    => 'maindb',
        // FPM、Workerman 下用
        'connections'   => [
            'maindb' => [
                'host'        => '127.0.0.1',
                'port'        => 3306,
                'username'    => 'root',
                'password'    => 'root',
                'database'    => 'mysql',
                'charset'     => 'utf8mb4',
                // 'port'    => '3306',
                // 'timeout' => '建立连接超时时间',
                // 'charset' => '',
                // 使用 hook pdo 驱动（缺省默认）
                // 'dbClass' => \Imi\Db\Drivers\PdoMysql\Driver::class,
                // 使用 hook mysqli 驱动
                // 'dbClass' => \Imi\Db\Drivers\Mysqli\Driver::class,
                // 使用 Swoole MySQL 驱动
                // 'dbClass' => \Imi\Swoole\Db\Drivers\Swoole\Driver::class,
                // 数据库连接后，执行初始化的 SQL
                // 'sqls' => [
                //     'select 1',
                //     'select 2',
                // ],
            ],
        ],
    ],

    // redis 配置
    'redis' => [
        // 数默认连接池名
        'defaultPool'   => 'redis',
        // FPM、Workerman 下用
        'connections'   => [
            'redis' => [
                'host'	 => '127.0.0.1',
                'port'	 => 6379,
                // 是否自动序列化变量
                'serialize'	 => true,
                // 密码
                'password'	 => null,
                // 第几个库
                'db'	 => 0,
            ],
        ],
    ],

    // 日志配置
    'logger' => [
        'channels' => [
            'imi' => [
                'handlers' => [
                    [
                        'class'     => \Imi\Log\Handler\ConsoleHandler::class,
                        'construct' => [
                            'level'  => \Imi\Log\MonoLogger::DEBUG, // 开发调试环境
                            // 'level'  => \Imi\Log\MonoLogger::INFO,  // 生产环境
                        ],
                        'formatter' => [
                            'class'     => \Imi\Log\Formatter\ConsoleLineFormatter::class,
                            'construct' => [
                                'format'                     => null,
                                'dateFormat'                 => 'Y-m-d H:i:s',
                                'allowInlineLineBreaks'      => true,
                                'ignoreEmptyContextAndExtra' => true,
                            ],
                        ],
                    ],
                    [
                        'class'     => \Monolog\Handler\RotatingFileHandler::class,
                        'construct' => [
                            'level'  => \Imi\Log\MonoLogger::DEBUG, // 开发调试环境
                            // 'level'  => \Imi\Log\MonoLogger::INFO,  // 生产环境
                            'filename' => App::get(AppContexts::APP_PATH_PHYSICS) . '/.runtime/logs/log.log',
                        ],
                        'formatter' => [
                            'class'     => \Monolog\Formatter\LineFormatter::class,
                            'construct' => [
                                'dateFormat'                 => 'Y-m-d H:i:s',
                                'allowInlineLineBreaks'      => true,
                                'ignoreEmptyContextAndExtra' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
