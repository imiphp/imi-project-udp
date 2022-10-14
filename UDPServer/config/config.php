<?php

declare(strict_types=1);

return [
    'configs'    => [
    ],
    'beans'    => [
        'UdpDispatcher'    => [
            'middlewares'    => [
                \Imi\Server\UdpServer\Middleware\RouteMiddleware::class,
            ],
        ],
    ],
];
