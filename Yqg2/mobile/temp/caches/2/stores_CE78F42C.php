<?php exit;?>a:3:{s:8:"template";a:5:{i:0;s:72:"D:/GitProject/YIQIGOU2/mobile/themesmobile/68ecshopcom_mobile/stores.dwt";i:1;s:81:"D:/GitProject/YIQIGOU2/mobile/themesmobile/68ecshopcom_mobile/library/up_menu.lbi";i:2;s:79:"D:/GitProject/YIQIGOU2/mobile/themesmobile/68ecshopcom_mobile/library/pages.lbi";i:3;s:85:"D:/GitProject/YIQIGOU2/mobile/themesmobile/68ecshopcom_mobile/library/page_footer.lbi";i:4;s:84:"D:/GitProject/YIQIGOU2/mobile/themesmobile/68ecshopcom_mobile/library/footer_nav.lbi";}s:7:"expires";i:1456151580;s:8:"maketime";i:1456147980;}<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>忆祺购  </title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<link rel="stylesheet" href="themesmobile/68ecshopcom_mobile/css/category_list.css">
<link rel="stylesheet" href="themesmobile/68ecshopcom_mobile/css/stores.css">
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<style>
.goods_nav{width:30%; float:right; right:5px; overflow:hidden; position:fixed;margin-top:-20px; z-index:9999999}
</style>
</head>
<body style=" background:#F5F5F5">
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">店铺街</div>
          <div class="h-right">
            <aside class="top_bar">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
      </header>
       	
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
        <div class="Triangle">
          <h2></h2>
        </div>
        <ul>
          <li><a href="index.php"><span class="menu1"></span><i>首页</i></a></li>
          <li><a href="catalog.php"><span class="menu2"></span><i>分类</i></a></li>
          <li><a href="flow.php"><span class="menu3"></span><i>购物车</i></a></li>
          <li style=" border:0;"><a href="user.php"><span class="menu4"></span><i>我的</i></a></li>
        </ul>
      </div> 
                
        
        
        <section class="filtrate_term" id="product_sort" style="width: 100%;">
<div class="list_top" >
    	<div class="ub" >
            <div class="list_tab ub ub-ac ub-pc" style="width:50%" onclick="opentanchu1()"><div id="sort" class="list_tabcon">
        女人            </div></div>            
             <div class="list_tab ub ub-ac ub-pc" style="width:45%" onClick="opentanchu2()" ><div id="quyu" class="list_tabcon">秦皇岛 海港区</div></div>
        </div>
        </div>        
    <div id="fenleitanchu" class='zitidian_div' style="display:none">
    <div class="f_bg fenleilist" style="overflow-y:scroll; height:auto">
       <div  onClick="javascript:location.href='stores.php'" >全部</div>
        <div  onClick="javascript:location.href='stores.php?id=2&cat_name=女人'"  style="color:#F00;">女人</div>
	    <div  onClick="javascript:location.href='stores.php?id=9&cat_name=生鲜配送'" >生鲜配送</div>
	     </div>
     <div class="close_div" onClick="closetanchu1()"></div>    
 </div>
 </div>
554fcae493e564ee0dc75bdf2ebf94caselect_region_category|a:1:{s:4:"name";s:22:"select_region_category";}554fcae493e564ee0dc75bdf2ebf94ca<script>
function opentanchu1(){
	$('#fenleitanchu').show();
	$('#quyutanchu').hide();
	$('html').addClass("sidebar-move");
	}
function closetanchu1(){
	$('#fenleitanchu').hide();
	$('html').removeClass("sidebar-move");
	}
function opentanchu2(){
	$('#quyutanchu').show();
	$('#fenleitanchu').hide();
	$('html').addClass("sidebar-move");
	}
function closetanchu2(){
	$('#quyutanchu').hide();
	$('html').removeClass("sidebar-move");
	}
function setTabQuyu(name,cursel){
	$('.district').removeClass('select');
	$('#'+name+cursel).addClass('select');
	$('.xiangcun').removeClass('con').hide();
	$('#'+name+"_"+cursel).addClass('con').show();
	setAreaCookie(3,cursel,name);
}
function setAreaCookie(level,value,name){
	document.cookie="region_"+level+"="+value;
	if(level == 3){
	//三级城市设置cookie
		if($('#'+name+"_"+value).html() == ''){
			document.cookie="region_4=0";
			top.location.href=top.location.href;
		}
	}
	if(level == 4){
		top.location.href=top.location.href;
	}
}
</script>	
</section>
        
        
        
        
        
        
<!--<div class="Packages">
<div class="all"><a  target="_self" href="stores.php" style="color:#FFF"><span>全部</span></a></div>
 <div class="page_guide_slider">
	<div class="page_guide_balloon" style=" display:none">
		<div class="page_guide_bar">
			<div class="page_guide_progress">
				<div></div>
			</div>
		</div>
	</div>	
	<div class="page_guide_container" onMouseDown="pageGuideMousedown(this,event)" onMouseMove="pageGuideMousemove(this,event)" onMouseUp="pageGuideMouseup(this,event)" onMouseOut="pageGuideMouseout(this,event)" ontouchstart="pageGuideTouchstart(this,event)" ontouchmove="pageGuideTouchmove(this,event)" ontouchend="pageGuideTouchend(this,event)">
    
		<div class="page_guide_items" style=" position:relative">		 
       
	 
            <div  class="page_guide_item">
		<div class="page_guide_item_text"><a class=" sele " target="_self" href="stores.php?id=2#street_cat2">女人</a></div>
            </div>
            <div id="street_cat2"></div>
         
            <div  class="page_guide_item">
		<div class="page_guide_item_text"><a class="" target="_self" href="stores.php?id=9#street_cat9">生鲜配送</a></div>
            </div>
            <div id="street_cat9"></div>
           
		</div>
	</div>
</div>
		        	<a target="_self" href="stores.php?id=2&amp;store_id=0&amp;type=3" class="" ><span>全部</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1194&amp;type=3" class="selected" ><span>海港区</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1195&amp;type=3" class="" ><span>山海关区</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1196&amp;type=3" class="" ><span>北戴河区</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1197&amp;type=3" class="" ><span>昌黎县</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1198&amp;type=3" class="" ><span>抚宁县</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1199&amp;type=3" class="" ><span>卢龙县</span></a>
	        	<a target="_self" href="stores.php?id=2&amp;store_id=1200&amp;type=3" class="" ><span>青龙</span></a>
		           
 
 </div> -->
<div class="footer" >
      <div class="links"  id="ECS_MEMBERZONE"> <script type="text/javascript" src="js/utils.js"></script>          554fcae493e564ee0dc75bdf2ebf94camember_info|a:1:{s:4:"name";s:11:"member_info";}554fcae493e564ee0dc75bdf2ebf94ca</div>
          <ul class="linkss" >
          <li>
            <a href="#">
            <i class="footerimg_1"></i>
            <span >客户端</span></a></li>
          <li>
          <a href="javascript:;"><i class="footerimg_2"></i><span class="gl">触屏版</span></a></li>
          <li><a href="index.php?is_c=1" class="goDesktop"><i class="footerimg_3"></i><span>电脑版</span></a></li></ul>
  	 <p class="mf_o4">&copy; 2005-2016 忆祺购 版权所有，并保留所有权利。</p>
</div>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
<div class="vf_nav">
<ul>
<li> <a href="./">
    <i class="vf_1"></i>
    <span>首页</span></a></li>
<li><a href="tel:554fcae493e564ee0dc75bdf2ebf94caservice_phone|a:1:{s:4:"name";s:13:"service_phone";}554fcae493e564ee0dc75bdf2ebf94ca">
    <i class="vf_2"></i>
    <span>联系我们</span></a></li>
<li><a href="catalog.php">
    <i class="vf_3"></i>
    <span>分类</span></a></li>
<li><a href="flow.php">
   <i class="vf_4" style=" width:28px;"></i>
   <span>购物车</span>
   <em class="global-nav__nav-shop-cart-num" id="ECS_CARTINFO" style=" margin-top:2px; margin-left:-1px;">554fcae493e564ee0dc75bdf2ebf94cacart_info|a:1:{s:4:"name";s:9:"cart_info";}554fcae493e564ee0dc75bdf2ebf94ca</em>
   </a></li>
<li><a href="user.php">
    <i class="vf_5"></i>
    <span>我的</span></a></li>
</ul>
</div>
</div>
    
<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="themesmobile/68ecshopcom_mobile/images/topup.png"></a> 
<script type="text/javascript">
//reg_package();
</script>
<script src="themesmobile/68ecshopcom_mobile/js/slider.js" type="text/javascript"></script>
</body>
</html>
