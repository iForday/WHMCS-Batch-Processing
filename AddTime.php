<?php
/*
    @author iForday
    @website https://mxidev.com/
    2018-09-16
 */
include 'init.php';
if (PHP_SAPI != 'cli') {
    exit('wtf');
}

$packageid = '1'; //产品/服务 ID
$resetTraffic = 'on'; //修改为off则不重置流量

$product = \WHMCS\Database\Capsule::table('tblhosting')->where('packageid', $packageid)->where('domainstatus', 'Active')->get();
$count = \WHMCS\Database\Capsule::table('tblhosting')->where('packageid', $packageid)->where('domainstatus', 'Active')->count();
echo '[' . date('Y-m-d H:i:s') . '] [INFO] 共有 ' . $count . ' 个服务需要补偿' . PHP_EOL;
foreach ($product as $key => $value) {
    $nextduedate = $value->nextduedate;
    $nextinvoicedate = $value->nextinvoicedate;
    if ($nextduedate == '0000-00-00') {
        continue;
    } else {
        $afterDueDate = date("Y-m-d",strtotime("+10 days",strtotime($nextduedate)));
        $afterinvoicedate = date("Y-m-d",strtotime("+10 days",strtotime($nextinvoicedate)));
        if ($resetTraffic == 'on') {
            $doReset = localAPI('ModuleCustom',array('accountid' => $value->id, 'func_name' => 'ResetTraffic'), \WHMCS\Database\Capsule::table('tbladmins')->orderBy('id','ASC')->first()->username);
        }
        $addDueDate = \WHMCS\Database\Capsule::table('tblhosting')->where('id', $value->id)->update(['nextduedate' => $afterDueDate, 'nextinvoicedate' => $afterinvoicedate]);
        echo '[' . date('Y-m-d H:i:s') . '] [INFO] 产品ID: '.$value->id.' 用户ID: '.$value->userid.' 补偿前到期日期: '.$nextduedate.' 补偿前账单日期: '.$nextinvoicedate.' 补偿后到期日期: '.$afterDueDate.' 补偿后账单日期: '.$afterinvoicedate.' 流量重置状态: '.$doReset['result'].PHP_EOL;
    }
}

