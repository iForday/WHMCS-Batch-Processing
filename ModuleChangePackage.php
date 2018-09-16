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
	echo '[' . date('Y-m-d H:i:s') . '] [INFO] 共有 ' . $count . ' 个服务需要更换产品套餐' . PHP_EOL;
	echo '[' . date('Y-m-d H:i:s') . '] [INFO] 5秒后继续，取消请按Ctrl + C ...' . PHP_EOL;
	sleep(5);
	foreach ($product as $key => $value) {
		try {
			$admin = Capsule::table('tbladmins')->orderBy('id','ASC')->first()->username;
			$ChangePackage = localAPI('ModuleCustom', ['accountid' => $value->id, 'func_name' => 'ChangePackage'], $admin);
			if ($ChangePackage['result'] == 'success') {
				echo '[' . date('Y-m-d H:i:s') . '] [INFO] 产品ID: ' . $value->id . ' 更换产品套餐成功' . PHP_EOL;
			} else {
				echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 产品ID ' . $value->id . ' 更换产品套餐时出错: ' . json_encode($ChangePackage, JSON_UNESCAPED_UNICODE) . PHP_EOL;
			}
		} catch (Exception $e) {
			echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 产品ID ' . $value->id . ' 更换产品套餐时出错: ' . $e->getMessage() . PHP_EOL;
		}
	}
} catch (Exception $e) {
	echo '[' . date('Y-m-d H:i:s') . '] [ERROR] 出现错误: ' . $e->getMessage() . PHP_EOL;
}
