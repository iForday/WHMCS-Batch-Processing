![MxiDev](https://mxidev.com/assets/svg/mxidev-blue.svg "MxiDev")
# WHMCS-Batch-Processing

***

这些是这段时间使用WHMCS时，遇到一些需要批量处理产品的业务需求而写的，希望能帮助到一些有类似需求的小伙伴，也顺便作为一个备份。本人水平欠佳，望大佬轻喷，若有什么问题，欢迎提交Issues，觉得有帮助请点个Star噢


### 使用方法: 将文件放入WHMCS的根目录，php 文件名.php 即可

### 以下是使用说明

#### AddTime.php

  - 该脚本可以批量给指定的产品/服务增加到期时间
  - 使用前请修改第12行的 /产品/服务 ID
  - /产品/服务 ID 可以在WHMCS后台->系统设置->/产品/服务->/产品/服务, 点击您希望补偿的服务，浏览器URL中最后的数字即为产品/服务 ID
  - 您还需修改补偿天数，位于第13行，+号代表加，-号代表减
  - 使用前请做好备份

***

#### CancelProduct.php

  - 该脚本可以给所有已激活的服务添加到期后取消的请求，来避免系统自动产生续费账单
  - 使用后建议前往系统后台取消用户的续费账单，以避免已发出账单的产品被续费
  - 前请做好备份，很适合跑路的


***

#### LSDelErrorAccount.php

  - 该脚本可以批量删除LegendSock中的黑户
  - 使用前请修改第14行的数据库ID，该ID可以在LegendSock控制面板找到
  - 使用前请做好备份


***


#### ModuleChangePackage.php
  - 该脚本可以给所有已激活的服务执行一次修改套餐动作
  - 适合LegendSock中批量修改用户的加密/混淆/协议
  - 其他用户请自行开发
  - 使用前请做好备份


Copyright © MxiDev.com All Rights Reserved.
