<?php
/*
	@author iForday
	@website https://mxidev.com/
	2018-09-16
 */
include 'init.php';
use \WHMCS\Database\Capsule;
if (PHP_SAPI != 'cli') {
    exit('wtf');
}
try {
	$product = Capsule::table('tblhosting')->where('domainstatus', 'Active')->get();
	$count = Capsule::table('tblhosting')->where('domainstatus', 'Active')->count();
	echo '[' . date('Y-m-d H:i:s') . '] [INFO] 共有 ' . $count . ' 个服务需要取消'.PHP_EOL;
	foreach ($product as $key => $value) {
		try {
			$check = Capsule::table('tblcancelrequests')->where('relid', $value->id)->first();
			if (empty($check)) {
				Capsule::table('tblcancelrequests')->insert([
					'date' => date('Y-m-d H:i:s'),
					'relid' => $value->id,
					'reason' => '系统自动取消',
					'type' => 'End of Billing Period',
				]);
				echo '[' . date('Y-m-d H:i:s') . '] [INFO] 产品ID ' . $value->id . ' 已完成取消请求' . PHP_EOL;
			} else {
				echo '[' . date('Y-m-d H:i:s') . '] [WARNING] 产品ID ' . $value->id . ' 已经有一个取消请求，已跳过' . PHP_EOL;
			}
		} catch (Exception $e) {
			echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 产品ID ' . $value->id . ' 添加取消请求时出错' . $e->getMessage() . PHP_EOL;
		}
	}
} catch (Exception $e) {
	echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 出现错误: ' . $e->getMessage() . PHP_EOL;
}
