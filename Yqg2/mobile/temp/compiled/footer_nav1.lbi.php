<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/bottom_nav.css"/>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
<div class="vf_nav">
<ul>
<li> <a href="./">
    <i class="footer_nav1"></i>
    <span>首页</span></a></li>
<li><a href="v_shop.php?user_id=<?php echo $this->_var['user_id']; ?>">
   <i class="footer_nav2"></i>
    <span>微店</span></a></li>
<li><a href="v_user.php">
    <i class="footer_nav3"></i>
    <span>分销中心</span></a></li>
<li><a href="flow.php">
   <i class="footer_nav4"></i>
   <span>购物车</span>
   <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style=" margin-top:2px; margin-left:-1px;"><?php 
$k = array (
  'name' => 'cart_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></em>
   </a></li>
<li><a href="user.php">
    <i class="footer_nav5"></i>
    <span>我的</span></a></li>
</ul>
</div>
</div>


