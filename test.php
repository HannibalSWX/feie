<?php

require "vendor/autoload.php";

use Feie\Printer;

$printer = (new Printer('2792938834@qq.com', 'FPDLT6n59wv32VEg'));

$orderInfo = '<CB>测试打印</CB><BR>';
        $orderInfo .= '名称　　　　　 单价  数量 金额<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $orderInfo .= '饭　　　　　 　10.0   10  10.0<BR>';
        $orderInfo .= '炒饭　　　　　 10.0   10  10.0<BR>';
        $orderInfo .= '蛋炒饭　　　　 10.0   100 100.0<BR>';
        $orderInfo .= '鸡蛋炒饭　　　 100.0  100 100.0<BR>';
        $orderInfo .= '西红柿炒饭　　 1000.0 1   100.0<BR>';
        $orderInfo .= '西红柿蛋炒饭　 100.0  100 100.0<BR>';
        $orderInfo .= '西红柿鸡蛋炒饭 15.0   1   15.0<BR>';
        $orderInfo .= '备注：加辣<BR>';
        $orderInfo .= '--------------------------------<BR>';
        $orderInfo .= '合计：xx.0元<BR>';
        $orderInfo .= '送货地点：广州市南沙区xx路xx号<BR>';
        $orderInfo .= '联系电话：13888888888888<BR>';
        $orderInfo .= '订餐时间：2014-08-08 08:08:08<BR>';
        $orderInfo .= '<QR>http://www.dzist.com</QR>';

//$result = $printer->deletePrinter('617501504')->getResult();

//$result = $printer->addPrinter('617501504', '2rakpjfx', '测试打印机');

//var_dump($result);
try {
    $result = $printer->print('617501504', $orderInfo)->getResult();
} catch (\Exception $e) {
    echo $e->getcode();
    echo $e->getMessage();
}

