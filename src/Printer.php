<?php

namespace Xiang1993\Feie;

use GuzzleHttp\Client;

class Printer
{
    private $host = 'https://api.feieyun.cn/Api/Open/';

    private $user;

    private $ukey;

    private $sn;

    private $stime;

    private $times = 1;

    private $result = null;

    public function __construct($user, $ukey)
    {
        $this->user = $user;
        $this->ukey = $ukey;
        $this->stime = time();
    }

    private function sign()
    {
        return sha1($this->user . $this->ukey . $this->stime);
    }

    public function getResult()
    {
        return $this->result;
    }

    public function request($apiname, $params)
    {
        $body['apiname'] = $apiname;
        $body['user'] = $this->user;
        $body['stime'] = $this->stime;
        $body['sig'] = $this->sign();

        $body = array_merge($body, $params);

        try {
            $result = json_decode((new Client)->post($this->host, ['form_params' => $body])->getBody(), true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), -1);
        }

        if ($result['ret'] != 0) {
            throw new \Exception($result['msg'], $result['ret']);
        } else {
            $this->result = $result['data'];
        }
    }

    /**
     * 打印
     */
    public function print($sn, $content, $times = 1)
    {
        $params['sn'] = $this->sn = $sn;
        $params['times'] = $this->times = $times;
        $params['content'] = $content;

        $this->request('Open_printMsg', $params);

        return $this;
    }

    /**
     * 添加打印机
     */
    public function addPrinter($sn, $key, $name = null, $phonenum = null)
    {
        $content = "{$sn} # {$key}";
        if (!empty($name)) {
            $content .= " # {$name}";
        }
        if (!empty($phonenum)) {
            $content .= " # {$phonenum}";
        }

        $params['printerContent'] = $content;

        $this->request('Open_printerAddlist', $params);

        return $this;
    }

    /**
     * 删除打印机
     */
    public function deletePrinter($sn)
    {
        $params['snlist'] = $sn;
        
        $this->request('Open_printerDelList', $params);

        return $this;
    }

    /**
     * 修改打印机信息
     */ 
    public function editPrinter($sn, $name = null, $phonenum = null)
    {
        $params['sn'] = $sn;
        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($phonenum)) {
            $params['phonenum'] = $phonenum;
        }
        
        $this->request('Open_printerEdit', $params);

        return $this;
    }

    /**
     * 清空待打印队列
     */
    public function flushSql($sn)
    {
        $params['sn'] = $sn;

        $this->request('Open_delPrinterSqs', $params);

        return $this;
    }

    /**
     * 查询订单是否打印成功
     */
    public function queryOrderStatus($order_id)
    {
        $params['orderid'] = $order_id;

        $this->request('Open_queryOrderState', $params);

        return $this;
    }

    /**
     * 查询指定打印机某天的订单统计数
     */
    public function queryOrderInfoByDate($sn, $date)
    {
        $params['sn'] = $sn;
        $params['date'] = $date;

        $this->request('Open_queryOrderInfoByDate', $params);

        return $this;
    }

    /**
     * 查询打印机状态
     */
    public function queryPrinterStatus($sn)
    {
        $params['sn'] = $sn;

        $this->request('Open_queryPrinterStatus', $params);

        return $this;
    }
}