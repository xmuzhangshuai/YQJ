<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ecs_store_money_log`;");
E_C("CREATE TABLE `ecs_store_money_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `rebateid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '佣金id',
  `addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:订单分佣,2:撤销分佣,3:佣金提现',
  `reason` varchar(60) NOT NULL COMMENT '日志变动原因',
  `supplier_money` decimal(10,2) NOT NULL COMMENT '资金时刻记录',
  `doman` varchar(30) NOT NULL COMMENT '操作人',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '入驻商id',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商(仓库)id',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销商(仓库)佣金日志表'");

require("../../inc/footer.php");
?>