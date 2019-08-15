<?php

use Imi\Log\LogLevel;
return [
    'configs'    =>    [
    ],
    // bean扫描目录
    'beanScan'    =>    [
        'ImiApp\UDPServer\Controller',
    ],
    'beans'    =>    [
        'UdpDispatcher'    =>    [
            'middlewares'    =>    [
                \Imi\Server\UdpServer\Middleware\RouteMiddleware::class,
            ],
        ],
    ],
];