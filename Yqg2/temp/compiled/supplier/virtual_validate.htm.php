<!-- $Id: auction_info.htm 16992 2010-01-19 08:45:49Z wangleisvn $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="../js/calendar.php?lang=<?php echo $this->_var['cfg_lang']; ?>"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js,../js/transport.org.js,../js/utils.js')); ?>

<div class="main-div">
<!-- #代码增加2014-12-23 by www.68ecshop.com  _star -->
<form method="post" action="virtual_goods.php?act=verification" name="theForm"  enctype="multipart/form-data">
<!-- #代码增加2014-12-23 by www.68ecshop.com  _end -->
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
  <td>请输入虚拟卷号码:</td><td><input type="text" name="verification" value="<?php echo $this->_var['result']['card_sn']; ?>"><input type="submit"  value="提交" class="button"></td>
  </tr>
  <tr>
      <td>
          <div>
              <?php if ($this->_var['result']['msg'] == '0'): ?>未找到此验证码,验证失败<script type="Text/Javascript" language="JavaScript">alert("未找到此验证码,验证失败");</script><?php endif; ?>
              <?php if ($this->_var['result']['msg'] == '1'): ?>验证成功<script type="Text/Javascript" language="JavaScript">alert("验证成功");</script><?php endif; ?>
              <?php if ($this->_var['result']['msg'] == '2'): ?>此验证码已被使用,验证失败<script type="Text/Javascript" language="JavaScript">alert("此验证码已被使用,验证失败");</script><?php endif; ?>
              <?php if ($this->_var['result']['msg'] == '3'): ?>此验证码已经过期,验证失败<script type="Text/Javascript" language="JavaScript">alert("此验证码已经过期,验证失败");</script><?php endif; ?>
          </div>
      </td>
  </tr>
</table>

</form>
</div>

<?php echo $this->fetch('pagefooter.htm'); ?>
