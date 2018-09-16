<?php
/*
	@author iForday
	@website https://mxidev.com/
	2018-09-16
 */
if (PHP_SAPI != 'cli') {
    exit('wtf you want to do');
}
require_once 'init.php';
require_once 'modules/addons/legendsock/class.php';

//数据库ID
$id = '2';

try {
	$ls = new \LegendSock\Extended();
	$data = $ls->getConnect($id);
	$getData = $data->runSQL(array('action' => array('product' => array('sql' => 'SELECT pid FROM user', 'all' => true)), 'trans' => false));
	if (empty($getData['product']['result'])) {
		throw new Exception('无法取出数据库 ID #' . $id . ' 中的产品');
	}
	$product = $getData['product']['result'];
	foreach ($product as $key => $value) {
		try {
			$getData = \WHMCS\Database\Capsule::table('tblhosting')->where('id', $value['pid'])->first();
			if (empty($getData)) {
				$data->runSQL(array('action' => array('del' => array('sql' => 'DELETE FROM user WHERE pid = ?', 'pre' => array($value['pid']))), 'trans' => false));
				echo '[' . date('Y-m-d H:i:s') . '] [INFO] 成功删除产品ID为 ' . $value['pid'] . ' 的黑户' . PHP_EOL;
			}
		} catch (Exception $e) {
			echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 出现错误:' . $e->getMessage() . PHP_EOL;
		}
	}
} catch (Exception $e) {
	echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 出现错误:' . $e->getMessage() . PHP_EOL;
}