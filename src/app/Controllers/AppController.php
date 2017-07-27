<?php
namespace app\Controllers;

use app\Models\AppModel;
use Server\Asyn\HttpClient\HttpClientPool;
use Server\Asyn\Redis\RedisAsynPool;
use Server\Asyn\TcpClient\SdTcpRpcPool;
use Server\Asyn\TcpClient\TcpClientPool;
use Server\CoreBase\Controller;
use Server\CoreBase\SwooleException;

/**
 * Created by PhpStorm.
 * User: zhangjincheng
 * Date: 16-7-15
 * Time: 下午3:51
 */
class AppController extends Controller
{
    /**
     * @var TaskDataModel
     */
    public $TaskDataModel;

    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name);
        $this->TaskDataModel = $this->loader->model('TaskDataModel', $this);
    }

}