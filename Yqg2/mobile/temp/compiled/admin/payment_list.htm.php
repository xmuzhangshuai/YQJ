<!-- $Id: payment_list.htm 15541 2009-01-08 10:29:01Z testyang $ -->

<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- start payment list -->

<div class="list-div" id="listDiv">

<table cellspacing='1' cellpadding='3'>

  <tr>



	<th align="center">请到pc端设置支付方式，后台->系统设置->支付方式</th>



  </tr>



</table>
</div>
<!-- end payment list -->
<script type="Text/Javascript" language="JavaScript">
<!--

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>