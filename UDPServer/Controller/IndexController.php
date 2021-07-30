<?php

namespace ImiApp\UDPServer\Controller;

use Imi\Server\UdpServer\Route\Annotation\UdpAction;
use Imi\Server\UdpServer\Route\Annotation\UdpController;
use Imi\Server\UdpServer\Route\Annotation\UdpRoute;

/**
 * 数据收发测试.
 * @UdpController
 */
class IndexController extends \Imi\Server\UdpServer\Controller\UdpController
{
    /**
     * 登录.
     *
     * @UdpAction
     * @UdpRoute({"action"="hello"})
     * @return void
     */
    public function hello()
    {
        return [
            'time'    =>    date($this->data->getFormatData()->format),
        ];
    }
}
