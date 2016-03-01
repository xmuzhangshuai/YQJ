<?php

/**
 * ECSHOP 动态内容函数库
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: lib_insert.php 17063 2010-03-25 06:35:46Z liuhui $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * 获得查询次数以及查询时间
 *
 * @access  public
 * @return  string
 */
function insert_query_info()
{
    if ($GLOBALS['db']->queryTime == '')
    {
        $query_time = 0;
    }
    else
    {
        if (PHP_VERSION >= '5.0.0')
        {
            $query_time = number_format(microtime(true) - $GLOBALS['db']->queryTime, 6);
        }
        else
        {
            list($now_usec, $now_sec)     = explode(' ', microtime());
            list($start_usec, $start_sec) = explode(' ', $GLOBALS['db']->queryTime);
            $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
        }
    }

    /* 内存占用情况 */
    if ($GLOBALS['_LANG']['memory_info'] && function_exists('memory_get_usage'))
    {
        $memory_usage = sprintf($GLOBALS['_LANG']['memory_info'], memory_get_usage() / 1048576);
    }
    else
    {
        $memory_usage = '';
    }

    /* 是否启用了 gzip */
    $gzip_enabled = gzip_enabled() ? $GLOBALS['_LANG']['gzip_enabled'] : $GLOBALS['_LANG']['gzip_disabled'];

    $online_count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('sessions'));

    /* 加入触发cron代码 */
    $cron_method = empty($GLOBALS['_CFG']['cron_method']) ? '<img src="api/cron.php?t=' . gmtime() . '" alt="" style="width:0px;height:0px;" />' : '';

    return sprintf($GLOBALS['_LANG']['query_info'], $GLOBALS['db']->queryCount, $query_time, $online_count) . $gzip_enabled . $memory_usage . $cron_method;
}

/**
 * 调用浏览历史
 *
 * @access  public
 * @return  string
 */
function insert_history()
{
    $str = '';
    if (!empty($_COOKIE['ECS']['history']))
    {
        $where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
        $sql   = 'SELECT goods_id, goods_name, goods_thumb, shop_price FROM ' . $GLOBALS['ecs']->table('goods') .
                " WHERE $where AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
        while ($row = $GLOBALS['db']->fetch_array($query))
        {
            $goods['goods_id'] = $row['goods_id'];
            $goods['goods_name'] = $row['goods_name'];
            $goods['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods['shop_price'] = price_format($row['shop_price']);
            $goods['url'] = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);

		  
            $str.='<li>
              <div class="p-img"><a target="_blank" href="'.$goods['url'].'"><img src="'.$goods['goods_thumb'].'" alt="'.$goods['goods_name'].'" width="50" height="50" /></a></div>
              <div class="p-name"><a target="_blank" href="'.$goods['url'].'">'.$goods['goods_name'].'</a> </div>
              <div class="p-price"> <strong class="J-p-${list.wid}">'.$goods['shop_price'].'</strong> </div>
            </li>';
        }
      
    }
    return $str;
}
function get_cainixihuan()
{
if(!empty($_COOKIE['ECS']['history']))
{
$where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
        $sql   = 'SELECT cat_id FROM ' . $GLOBALS['ecs']->table('goods') .
                " WHERE $where AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0 limit 1";
$catid = $GLOBALS['db']->getOne($sql);
if($catid)
{
	$catid=$catid;
}
else
{
	$catid=0;
}
$sql = "select * from ".$GLOBALS['ecs']->table('goods')." where cat_id = ".$catid." and is_best = 1 AND is_delete = 0";
$list = $GLOBALS['db']->getAll($sql);
$arr = array();
foreach($list as $key => $rows)
{
$arr[$key]['goods_id'] = $rows['goods_id'];
$arr[$key]['goods_name'] = $rows['goods_name'];
$arr[$key]['goods_thumb'] = $rows['goods_thumb'];
$arr[$key]['shop_price'] = $rows['shop_price'];
$arr[$key]['url'] = build_uri('goods', array('gid'=>$rows['goods_id']), $rows['goods_name']);
$arr[$key]['evaluation']   = get_evaluation_sumss($rows['goods_id']);
}
return $arr;
}
}
function get_evaluation_sumss($goods_id)
{
$sql = "SELECT count(*) FROM " . $GLOBALS['ecs']->table('comment') . " WHERE status=1 and  comment_type =0 and id_value =".$goods_id ;//status=1表示通过了的评论才算  comment_type =0表示针对商品的评价 感谢zhangyh的提醒
    return $GLOBALS['db']->getOne($sql);
}
/* 代码增加_start  By  www.68ecshop.com */
/**
 * 调用浏览历史
 *
 * @access  public
 * @return  string
 */
function insert_history_list()
{
    $str = '';
    if (!empty($_COOKIE['ECS']['history']))
    {
        $where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
        $sql   = 'SELECT goods_id, goods_name, goods_thumb, shop_price,promote_price,market_price, goods_type FROM ' . $GLOBALS['ecs']->table('goods') .
                " WHERE $where AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
		$str .= '<ul>';
        while ($row = $GLOBALS['db']->fetch_array($query))
        {
            $goods['goods_id'] = $row['goods_id'];
            $goods['goods_name'] = $row['goods_name'];
			$goods['goods_type'] = $row['goods_type'];
            $goods['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods['shop_price'] = price_format($row['shop_price']);
            $goods['url'] = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
				if ($_SESSION['user_id'] > 0){
				if($row['promote_price'] != 0){
					$showprice = price_format($row['promote_price']);
				}else{
					$showprice = $goods['shop_price'];
				}
			}else{
				$showprice = price_format($row['market_price']);
			}
            //$str.='<ul class="clearfix"><li class="goodsimg"><a href="'.$goods['url'].'" target="_blank"><img src="'.$goods['goods_thumb'].'" alt="'.$goods['goods_name'].'" class="B_blue" /></a></li><li><a href="'.$goods['url'].'" target="_blank" title="'.$goods['goods_name'].'">'.$goods['short_name'].'</a><br />'.$GLOBALS['_LANG']['shop_price'].'<font class="f1">'.$goods['shop_price'].'</font><br /></li></ul>';
			$str .= '<li><div class="item_wrap">
				<div class="dt"><a href="' . $goods['url'] .'"><img width="50" height="50" src="' . $goods['goods_thumb'] . '" /></a></div>
				<div class="dd">
					<a class="name" href="' . $goods['url'] . '">' . $goods['goods_name'] . '</a>
					<div class="btn" style="padding-top:15px;">
						<a class="compare-btn" data-goods="' . $goods['goods_id'] .
						'" onClick="Compare.add(' . $goods['goods_id'] . ',\'' . $goods['goods_name'] .'\',' .
						$goods['goods_type'] . ', \'' .
						$goods['goods_thumb'] . '\', \'' . $showprice . '\')"></a>
						<span class="price" style="float:left"><strong>' . $showprice . '</strong></span>
					</div>
				</div>
			</div></li>';
        }
		$str .='</ul>';
        //$str .= '<ul id="clear_history"><a onclick="clear_history()">' . $GLOBALS['_LANG']['clear_history'] . '</a></ul>';
    }
    return $str;
}
/* 代码增加_end  By  www.68ecshop.com */
/**
 * 调用购物车信息
 *
 * @access  public
 * @return  string
 */
function insert_cart_info()
{
	$sql_where = $_SESSION['user_id']>0 ? "c.user_id='". $_SESSION['user_id'] ."' " : "c.session_id = '" . SESS_ID . "' AND c.user_id=0 ";
    $sql = 'SELECT c.*,g.goods_thumb,g.goods_id,c.goods_number,c.goods_price' .
           ' FROM ' . $GLOBALS['ecs']->table('cart') ." AS c ".
					 " LEFT JOIN ".$GLOBALS['ecs']->table('goods')." AS g ON g.goods_id=c.goods_id ".
           " WHERE $sql_where AND rec_type = '" . CART_GENERAL_GOODS . "'";
    $row = $GLOBALS['db']->GetAll($sql);
		$arr = array();
		foreach($row AS $k=>$v)
		{
				$arr[$k]['goods_thumb']  =get_image_path($v['goods_id'], $v['goods_thumb'], true);
        $arr[$k]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                               sub_str($v['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $v['goods_name'];
				$arr[$k]['url']          = build_uri('goods', array('gid' => $v['goods_id']), $v['goods_name']);
				$arr[$k]['goods_number'] = $v['goods_number'];
				$arr[$k]['goods_name']   = $v['goods_name'];
				$arr[$k]['goods_price']  = price_format($v['goods_price']);
				$arr[$k]['rec_id']       = $v['rec_id'];
		}		
    $sql = 'SELECT SUM(goods_number) AS number, SUM(goods_price * goods_number) AS amount' .
           ' FROM ' . $GLOBALS['ecs']->table('cart') ." AS c ".
           " WHERE $sql_where AND rec_type = '" . CART_GENERAL_GOODS . "'";
    $row = $GLOBALS['db']->GetRow($sql);

    if ($row)
    {
        $number = intval($row['number']);
        $amount = floatval($row['amount']);
    }
    else
    {
        $number = 0;
        $amount = 0;
    }

    $GLOBALS['smarty']->assign('str',sprintf($GLOBALS['_LANG']['cart_info'], $number, price_format($amount, false)));
		$GLOBALS['smarty']->assign('goods',$arr);
		
    $output = $GLOBALS['smarty']->fetch('library/cart_info.lbi');
    return $output;
}

/**
 * 调用指定的广告位的广告
 *
 * @access  public
 * @param   integer $id     广告位ID
 * @param   integer $num    广告数量
 * @return  string
 */
function insert_ads($arr)
{
    static $static_res = NULL;

    $time = gmtime();
    if (!empty($arr['num']) && $arr['num'] != 1)
    {
        $sql  = 'SELECT a.ad_id, a.position_id, a.media_type, a.ad_link, a.ad_code, a.ad_name, p.ad_width, ' .
                    'p.ad_height, p.position_style, RAND() AS rnd ' .
                'FROM ' . $GLOBALS['ecs']->table('ad') . ' AS a '.
                'LEFT JOIN ' . $GLOBALS['ecs']->table('ad_position') . ' AS p ON a.position_id = p.position_id ' .
                "WHERE enabled = 1 AND start_time <= '" . $time . "' AND end_time >= '" . $time . "' ".
                    "AND a.position_id = '" . $arr['id'] . "' " .
                'ORDER BY rnd LIMIT ' . $arr['num'];
        $res = $GLOBALS['db']->GetAll($sql);
    }
    else
    {
        if ($static_res[$arr['id']] === NULL)
        {
            $sql  = 'SELECT a.ad_id, a.position_id, a.media_type, a.ad_link, a.ad_code, a.ad_name, p.ad_width, '.
                        'p.ad_height, p.position_style, RAND() AS rnd ' .
                    'FROM ' . $GLOBALS['ecs']->table('ad') . ' AS a '.
                    'LEFT JOIN ' . $GLOBALS['ecs']->table('ad_position') . ' AS p ON a.position_id = p.position_id ' .
                    "WHERE enabled = 1 AND a.position_id = '" . $arr['id'] .
                        "' AND start_time <= '" . $time . "' AND end_time >= '" . $time . "' " .
                    'ORDER BY rnd LIMIT 1';
            $static_res[$arr['id']] = $GLOBALS['db']->GetAll($sql);
        }
        $res = $static_res[$arr['id']];
    }
    $ads = array();
    $position_style = '';

    foreach ($res AS $row)
    {
        if ($row['position_id'] != $arr['id'])
        {
            continue;
        }
        $position_style = $row['position_style'];
        switch ($row['media_type'])
        {
            case 0: // 图片广告
                $src = (strpos($row['ad_code'], 'http://') === false && strpos($row['ad_code'], 'https://') === false) ?
                        DATA_DIR . "/afficheimg/$row[ad_code]" : $row['ad_code'];
                $ads[] = "<a href='affiche.php?ad_id=$row[ad_id]&amp;uri=" .urlencode($row["ad_link"]). "'
                target='_blank'><img src='$src' width='" .$row['ad_width']. "' height='$row[ad_height]'
                border='0' /></a>";
                break;
            case 1: // Flash
                $src = (strpos($row['ad_code'], 'http://') === false && strpos($row['ad_code'], 'https://') === false) ?
                        DATA_DIR . "/afficheimg/$row[ad_code]" : $row['ad_code'];
                $ads[] = "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" " .
                         "codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\"  " .
                           "width='$row[ad_width]' height='$row[ad_height]'>
                           <param name='movie' value='$src'>
                           <param name='quality' value='high'>
                           <embed src='$src' quality='high'
                           pluginspage='http://www.macromedia.com/go/getflashplayer'
                           type='application/x-shockwave-flash' width='$row[ad_width]'
                           height='$row[ad_height]'></embed>
                         </object>";
                break;
            case 2: // CODE
                $ads[] = $row['ad_code'];
                break;
            case 3: // TEXT
                $ads[] = "<a href='affiche.php?ad_id=$row[ad_id]&amp;uri=" .urlencode($row["ad_link"]). "'
                target='_blank'>" .htmlspecialchars($row['ad_code']). '</a>';
                break;
        }
    }
    $position_style = 'str:' . $position_style;

    $need_cache = $GLOBALS['smarty']->caching;
    $GLOBALS['smarty']->caching = false;

    $GLOBALS['smarty']->assign('ads', $ads);
    $val = $GLOBALS['smarty']->fetch($position_style);

    $GLOBALS['smarty']->caching = $need_cache;

    return $val;
}

/**
 * 调用会员信息
 *
 * @access  public
 * @return  string
 */
function insert_member_info()
{
    $need_cache = $GLOBALS['smarty']->caching;
    $GLOBALS['smarty']->caching = false;

    if ($_SESSION['user_id'] > 0)
    {
        $GLOBALS['smarty']->assign('user_info', get_user_info());
    }
    else
    {
        if (!empty($_COOKIE['ECS']['username']))
        {
            $GLOBALS['smarty']->assign('ecs_username', stripslashes($_COOKIE['ECS']['username']));
        }
        $captcha = intval($GLOBALS['_CFG']['captcha']);
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
        {
            $GLOBALS['smarty']->assign('enabled_captcha', 1);
            $GLOBALS['smarty']->assign('rand', mt_rand());
        }
    }
    $output = $GLOBALS['smarty']->fetch('library/member_info.lbi');

    $GLOBALS['smarty']->caching = $need_cache;

    return $output;
}
/**
 * 商家入驻首页调用会员信息
 *
 * @access  public
 * @return  string
 */
function insert_member_info1()
{
    $need_cache = $GLOBALS['smarty']->caching;
    $GLOBALS['smarty']->caching = false;

    if ($_SESSION['user_id'] > 0)
    {
        $GLOBALS['smarty']->assign('user_info', get_user_info());
    }
    else
    {
        if (!empty($_COOKIE['ECS']['username']))
        {
            $GLOBALS['smarty']->assign('ecs_username', stripslashes($_COOKIE['ECS']['username']));
        }
        $captcha = intval($GLOBALS['_CFG']['captcha']);
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
        {
            $GLOBALS['smarty']->assign('enabled_captcha', 1);
            $GLOBALS['smarty']->assign('rand', mt_rand());
        }
    }
    $output = $GLOBALS['smarty']->fetch('library/member_info1.lbi');

    $GLOBALS['smarty']->caching = $need_cache;

    return $output;
}
/**
 * 调用评论信息
 *
 * @access  public
 * @return  string
 */
function insert_comments($arr)
{
    $need_cache = $GLOBALS['smarty']->caching;
    $need_compile = $GLOBALS['smarty']->force_compile;

    $GLOBALS['smarty']->caching = false;
    $GLOBALS['smarty']->force_compile = true;

    /* 验证码相关设置 */
    if ((intval($GLOBALS['_CFG']['captcha']) & CAPTCHA_COMMENT) && gd_version() > 0)
    {
        $GLOBALS['smarty']->assign('enabled_captcha', 1);
        $GLOBALS['smarty']->assign('rand', mt_rand());
    }
    $GLOBALS['smarty']->assign('username',     stripslashes($_SESSION['user_name']));
    $GLOBALS['smarty']->assign('email',        $_SESSION['email']);
    $GLOBALS['smarty']->assign('comment_type', $arr['type']);
    $GLOBALS['smarty']->assign('id',           $arr['id']);
    $cmt = assign_comment($arr['id'],          $arr['type']);
    $GLOBALS['smarty']->assign('comments',     $cmt['comments']);
    $GLOBALS['smarty']->assign('pager',        $cmt['pager']);


    $val = $GLOBALS['smarty']->fetch('library/comments_list.lbi');

    $GLOBALS['smarty']->caching = $need_cache;
    $GLOBALS['smarty']->force_compile = $need_compile;

    return $val;
}


/**
 * 调用商品购买记录
 *
 * @access  public
 * @return  string
 */
function insert_bought_notes($arr)
{
    $need_cache = $GLOBALS['smarty']->caching;
    $need_compile = $GLOBALS['smarty']->force_compile;

    $GLOBALS['smarty']->caching = false;
    $GLOBALS['smarty']->force_compile = true;

    /* 商品购买记录 */
    $sql = 'SELECT u.user_name, og.goods_number, oi.add_time, IF(oi.order_status IN (2, 3, 4), 0, 1) AS order_status ' .
           'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
           'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $arr['id'] . ' ORDER BY oi.add_time DESC LIMIT 5';
    $bought_notes = $GLOBALS['db']->getAll($sql);

    foreach ($bought_notes as $key => $val)
    {
        $bought_notes[$key]['add_time'] = local_date("Y-m-d G:i:s", $val['add_time']);
    }

    $sql = 'SELECT count(*) ' .
           'FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi LEFT JOIN ' . $GLOBALS['ecs']->table('users') . ' AS u ON oi.user_id = u.user_id, ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
           'WHERE oi.order_id = og.order_id AND ' . time() . ' - oi.add_time < 2592000 AND og.goods_id = ' . $arr['id'];
    $count = $GLOBALS['db']->getOne($sql);


    /* 商品购买记录分页样式 */
    $pager = array();
    $pager['page']         = $page = 1;
    $pager['size']         = $size = 5;
    $pager['record_count'] = $count;
    $pager['page_count']   = $page_count = ($count > 0) ? intval(ceil($count / $size)) : 1;;
    $pager['page_first']   = "javascript:gotoBuyPage(1,$arr[id])";
    $pager['page_prev']    = $page > 1 ? "javascript:gotoBuyPage(" .($page-1). ",$arr[id])" : 'javascript:;';
    $pager['page_next']    = $page < $page_count ? 'javascript:gotoBuyPage(' .($page + 1) . ",$arr[id])" : 'javascript:;';
    $pager['page_last']    = $page < $page_count ? 'javascript:gotoBuyPage(' .$page_count. ",$arr[id])"  : 'javascript:;';

    $GLOBALS['smarty']->assign('notes', $bought_notes);
    $GLOBALS['smarty']->assign('pager', $pager);


    $val= $GLOBALS['smarty']->fetch('library/bought_notes.lbi');

    $GLOBALS['smarty']->caching = $need_cache;
    $GLOBALS['smarty']->force_compile = $need_compile;

    return $val;
}


/**
 * 调用在线调查信息
 *
 * @access  public
 * @return  string
 */
function insert_vote()
{
    $vote = get_vote();
    if (!empty($vote))
    {
        $GLOBALS['smarty']->assign('vote_id',     $vote['id']);
        $GLOBALS['smarty']->assign('vote',        $vote['content']);
    }
    $val = $GLOBALS['smarty']->fetch('library/vote.lbi');

    return $val;
}

/**
 * 调用入驻商申请
 */
function insert_apply_supplier($user){
	global $_CFG;
	//申请步骤
    $apply_info = array(0=>'one',1=>'two_1',2=>'two_2',3=>'three',4=>'ing',5=>'four',6=>'fail');
    
    $sql = "select * from ".$GLOBALS['ecs']->table('supplier')." where user_id = ".$user['id'].' limit 1';
    $supplier = $GLOBALS['db']->getRow($sql);
    
    if($supplier){
    	$shownum = ++$supplier['applynum'];
    }else{
    	$shownum = 0;
    }
    //要显示的阶段
    $shownum = (isset($_GET['shownum'])) ? intval($_GET['shownum']) : $shownum;
    
	if($supplier){
    	$shownum = ($supplier['status']<0) ? 6 : (($supplier['status']>0) ? 5 : $shownum);
    }
    
    if($shownum == 1){
    	$supplier_country = $supplier['country'] ?  $supplier['country'] : $_CFG['shop_country'];
		$GLOBALS['smarty']->assign('country_list',       get_regions());	
		$GLOBALS['smarty']->assign('province_list', get_regions(1, $supplier_country));
		$GLOBALS['smarty']->assign('city_list', get_regions(2, $supplier['province']));
		$GLOBALS['smarty']->assign('district_list', get_regions(3, $supplier['city']));
		$GLOBALS['smarty']->assign('supplier_country', $supplier_country);
		$company_type = explode("\n", str_replace("\r\n", "\n", $_CFG['company_type']));
		$GLOBALS['smarty']->assign('company_type', $company_type);
    }elseif($shownum == 3){
    	$sql="select rank_id,rank_name from ". $GLOBALS['ecs']->table('supplier_rank') ." order by sort_order";
		$supplier_rank=$GLOBALS['db']->getAll($sql);
		$GLOBALS['smarty']->assign('supplier_rank', $supplier_rank);
		$sql="select str_id,str_name from ". $GLOBALS['ecs']->table('street_category') ." where is_show=1 order by sort_order";
		$supplier_type=$GLOBALS['db']->getAll($sql);
		$GLOBALS['smarty']->assign('supplier_type', $supplier_type);
    }elseif($shownum == 5){
    	/**/
    	$supplier_country = $supplier['country'] ?  $supplier['country'] : $_CFG['shop_country'];
		$GLOBALS['smarty']->assign('country_list',       get_regions());	
		$GLOBALS['smarty']->assign('province_list', get_regions(1, $supplier_country));
		$GLOBALS['smarty']->assign('city_list', get_regions(2, $supplier['province']));
		$GLOBALS['smarty']->assign('district_list', get_regions(3, $supplier['city']));
		$GLOBALS['smarty']->assign('supplier_country', $supplier_country);
    	/* 供货商等级 */
		$sql="select rank_name from ". $GLOBALS['ecs']->table('supplier_rank') ." where rank_id = ".$supplier['rank_id'];
		$rank_name=$GLOBALS['db']->getOne($sql);
		$supplier['rank_name'] = $rank_name;
		/* 店铺类型 */
		 $sql="select str_name from ". $GLOBALS['ecs']->table('street_category') ." where str_id = ".$supplier['type_id'];
		$type_name=$GLOBALS['db']->getOne($sql);
		$supplier['type_name'] = $type_name;
		
		$GLOBALS['smarty']->assign('mydomain', $GLOBALS['ecs']->url());
    }
    
    
    
    $GLOBALS['smarty']->assign('supplier',       $supplier);
    
    $val = $GLOBALS['smarty']->fetch('library/apply_'.$apply_info[$shownum].'.lbi');

    return $val;
}


/*jdy add 0818*/
/**
* 调用某商品的累积售出
*/
function insert_goods_sells($arr)
{
    $sql = 'SELECT SUM(goods_number) AS number ' .
           ' FROM ' . $GLOBALS['ecs']->table('order_goods') ." AS og , " . $GLOBALS['ecs']->table('order_info') ." AS  o ".
           " WHERE og.order_id = o.order_id and og.goods_id=".$arr['goods_id'];
    $row = $GLOBALS['db']->GetRow($sql);
    if ($row)
    {
        $number = intval($row['number']);
    }
    else
    {
        $number = 0;
    }
    return $number;
}
/* 代码增加_start By www.68ecshop.com */
/**
 * 调用评论信息
 *
 * @access  public
 * @return  string
 */
function insert_question($arr)
{
    $need_cache = $GLOBALS['smarty']->caching;
    $need_compile = $GLOBALS['smarty']->force_compile;

    $GLOBALS['smarty']->caching = false;
    $GLOBALS['smarty']->force_compile = true;

    /* 验证码相关设置 */
    if ((intval($GLOBALS['_CFG']['captcha']) & CAPTCHA_QUESTION) && gd_version() > 0)
    {
        $GLOBALS['smarty']->assign('enabled_captcha_question', 1);
        $GLOBALS['smarty']->assign('rand', mt_rand());
    }
    $GLOBALS['smarty']->assign('username',     stripslashes($_SESSION['user_name']));
    $GLOBALS['smarty']->assign('email',        $_SESSION['email']);
    $GLOBALS['smarty']->assign('id',           $arr['id']);
    $cmt = assign_question($arr['id']);
    $GLOBALS['smarty']->assign('question_list',     $cmt['comments']);
    $GLOBALS['smarty']->assign('pager',        $cmt['pager']);


    $val = $GLOBALS['smarty']->fetch('library/question_list.lbi');

    $GLOBALS['smarty']->caching = $need_cache;
    $GLOBALS['smarty']->force_compile = $need_compile;

    return $val;
}
/* 代码增加_end By www.68ecshop.com */

/*
 * 调用店铺logo与首页 
 */
function insert_supplier_list(){
	
	$need_cache = $GLOBALS['smarty']->caching;
    $need_compile = $GLOBALS['smarty']->force_compile;
    
	$sql = "SELECT ssc.value,ssc.supplier_id,ssc.code FROM ".$GLOBALS['ecs']->table('supplier')." as s,".$GLOBALS['ecs']->table('supplier_shop_config')." as ssc WHERE s.`status` = 1 AND ssc.supplier_id = s.supplier_id AND code in('shop_name','shop_logo') limit 48";
    $query = $GLOBALS['db']->query($sql);
    $ret = array();
    while ($row = $GLOBALS['db']->fetch_array($query)){
    	$row['value'] = empty($row['value']) ? '/data/supplier/dianpu.jpg' : $row['value'];
    	$ret[$row['supplier_id']][$row['code']] = $row['value'];
    	$ret[$row['supplier_id']]['shop_url'] = 'supplier.php?suppId='.$row['supplier_id'];
    }
    $num = 24 - count($ret);
    if($num > 0){
    	for($i=0;$i<$num;$i++){
    		$ret[] = array('shop_name'=>'虚位以待','shop_logo'=>'/data/supplier/ad.jpg','shop_url'=>'#');
    	}
    }
    
    $newret = array_chunk($ret,6,true);

    
     $GLOBALS['smarty']->assign('supplier_logo',        $newret);
     
     $val = $GLOBALS['smarty']->fetch('library/index_stores.lbi');

    $GLOBALS['smarty']->caching = $need_cache;
    $GLOBALS['smarty']->force_compile = $need_compile;

    return $val;
}
/**
 * 调用某商品的累积收藏
*/
function insert_goods_collect($arr)
 {
         $sql='select count(user_id) as ids '.'from '. $GLOBALS['ecs']->table('collect_goods')."as co "."where co.goods_id=".$arr['goods_id'];
         $row=$GLOBALS['db']->GetRow($sql);
         if($row)
         {
                 $ids = intval($row['ids']);
         }
         else
         {
                 $ids = 0;
         }
         return $ids;
 }

// morestock_morecity start

function insert_get_pickup_point_list(){
	global $smarty;
	$need_cache = $smarty->caching;
    $need_compile = $smarty->force_compile;
	$district_id = (isset($_REQUEST['district']) && intval($_REQUEST['district'])>0) ? intval($_REQUEST['district']) : 0;
	$sql = 'select * from ' . $GLOBALS['ecs']->table('pickup_point') . ' where district_id=' . $district_id;
	$pickup_point_list = $GLOBALS['db']->getAll($sql);
	$smarty->assign('pickupinfo',$pickup_point_list);

	$val = $smarty->fetch('library/pickup_info.lbi');

    $smarty->caching = $need_cache;
    $smarty->force_compile = $need_compile;

    return $val;
}
 
 
/*
 * 获取选择的城市下的所有信息

 */
function insert_select_region($arr){
	
	global $ecs,$db,$smarty;
	$need_cache = $smarty->caching;
    $need_compile = $smarty->force_compile;
	
	$newpcca = array();
	$pcca = $_REQUEST['datainfo'];
	foreach($pcca as $key=>$val){
		if(isset($_REQUEST[$val]) && intval($_REQUEST[$val])>0){
			$newpcca[$key]=intval($_REQUEST[$val]);
		}
	}
	//echo "<pre>";
	//print_r($newpcca);
	$regions =array();
	foreach($newpcca as $k=>$v){
		
		if($k == 1){//所有省
			$sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 group by ".$pcca[$k];
		}else{//所有市，县，区
			//$sql = "select region_id,region_name from ". $ecs->table("region") ." where parent_id = ".$newpcca[$k-1];
			$sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 and ssr.".$pcca[$k-1]."=".$newpcca[$k-1]." group by ".$pcca[$k];
		}
		//$sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 group by ".$pcca[$k];
		$res= $db->query($sql);
		while($row = $db->fetchRow($res))
		{
			   $regions[$pcca[$k]][$row['region_id']] = $row['region_name'] ;
		}
	}

	

	$names = array();
	$sql = "select region_id,region_name,region_type from ". $ecs->table("region") ." where region_id in (".implode(',',$newpcca).")";
	$ress = $db->query($sql);
	while($rows = $db->fetchRow($ress)){
		$names[$rows['region_type']] = $rows['region_name'];
	}
	ksort($names);
	foreach($pcca as $key=>$val){//填满四个地区的位置
		if(!isset($names[$key])){
			$names[$key] = '';
		}
	}

	$smarty->assign('fullname',implode('',$names));//要显示的全名

	$next_regions = array();
	$le = count($newpcca);
	$k = $le+1;
	if($k < 5){//一共就四级
		
		$sql = "select r.region_id,r.region_name from ". $ecs->table("store_shipping_region") ." as ssr left join ". $ecs->table("region") ." as r on ssr.".$pcca[$k]."=r.region_id where ssr.".$pcca[$k].">0 and ssr.".$pcca[$k-1]."=".$newpcca[$k-1]." group by ".$pcca[$k];
		$res= $db->query($sql);
		while($row = $db->fetchRow($res))
		{
			$next_regions[$row['region_id']] = $row['region_name'] ;
		}
		
	}
	if(count($next_regions)>0){
		$regions[$pcca[$k]] = $next_regions;
		$names[$k] = '请选择';
	}else{
		$k--;
	}
	
	$smarty->assign('divlevels',$pcca);//共多少级层
	$smarty->assign('levelsinfo',$regions);//每级层当中的内容
	$smarty->assign('shownames',$names);//要显示的地址名称
	//$smarty->assign('fullname',implode('',$names));//要显示的全名
	$smarty->assign('from',$arr['from']);
	$smarty->assign('address_title',$arr['title']);
	$smarty->assign('showlevel',$k);

	$val = $smarty->fetch('library/region_city.lbi');

    $smarty->caching = $need_cache;
    $smarty->force_compile = $need_compile;

    return $val;
}

/*
 * 获取头部当前城市
 * 
 */
function insert_mycity($arr)
{
	global $ecs,$db,$smarty;
	$need_cache = $smarty->caching;
    $need_compile = $smarty->force_compile;
	
    //$sqlr="select * from ". $GLOBALS['ecs']->table('region') ." where region_type =2";
    $sql = "select r.* from ".$ecs->table('store_shipping_region')." as ssr left join ".$ecs->table('region')." as r on ssr.city=r.region_id where ssr.city>0 group by ssr.city";
	$res_region=$db->query($sql);
	$zimu_city=array();
	while ($row_region = $db->fetchRow($res_region))
	{	
		$zimu=GetPinyin($row_region['region_name'],1);
		$zimu=strtoupper(substr($zimu,0,1));
		$zimu_city[$zimu][$row_region['region_id']]=array(
			'region_id'=>$row_region['region_id'],
			'region_name' =>$row_region['region_name'],
			'level' => 2
			);
	}
	$smarty->assign('zimu_city', $zimu_city);
	$smarty->assign('nowcityname',$db->getOne("select region_name from ".$ecs->table("region")." where region_id=".$_REQUEST['city']));
    
	$val = $smarty->fetch('library/header_city.lbi');
    
    $smarty->caching = $need_cache;
    $smarty->force_compile = $need_compile;
	return $val;
}

/**
* 获取首页弹框城市切换
*/
function insert_index_city_div(){
	if(isset($_COOKIE['region_select']) && !empty($_COOKIE['region_select'])){
		return '';
	}
	global $ecs,$db,$smarty;
	$need_cache = $smarty->caching;
    $need_compile = $smarty->force_compile;
    $sql = "select r.* from ".$ecs->table('store_shipping_region')." as ssr left join ".$ecs->table('region')." as r on ssr.city=r.region_id where ssr.city>0 group by ssr.city";
	$res_region=$db->query($sql);
	$citys = array();
	while ($row_region = $db->fetchRow($res_region))
	{	
		$citys[$row_region['region_id']]=array(
			'region_id'=>$row_region['region_id'],
			'region_name' =>$row_region['region_name']
			);
	}
	$smarty->assign('citys', $citys);
	$val = $smarty->fetch('library/index_city.lbi');
    
    $smarty->caching = $need_cache;
    $smarty->force_compile = $need_compile;
	return $val;
}

/**
* 获取不同商家的运费方式
**/
function insert_get_shop_shipping($arr){
	global $db,$ecs;
	$order = $_SESSION['flow_order'];//获取订单信息
	$suppid = intval($arr['suppid']);
	$stock_type = 0;
	if($suppid>0){
		$stock_type = $db->getOne("select type from ".$ecs->table("store_type")." where supplier_id=".$suppid);
	}
	$where = '';
	foreach($_REQUEST['datainfo'] as $k=>$v){
		$where .= " and ".$v."=".$_COOKIE['region_'.$k];
	}
	$select_html = "<select name='pay_ship[".$suppid."]' id='pay_ship_".$suppid."' onchange='selectShipping(this.value,".$suppid.");' class='shipping'>";
	$sql = "select s.shipping_name,ssf.fee_id,ssf.configure from ".$ecs->table("store_shipping_region")." as ssr,".$ecs->table("store_shipping_fee")." as ssf,".$ecs->table("shipping")." as s where ssr.supplier_id=".$stock_type.$where." and ssr.rec_id=ssf.shipping_region_id and ssf.shipping_id=s.shipping_id";

	$isZhiChi = $db->getRow($sql);
	$ret = $db->query($sql);
	if($ret && $isZhiChi){
		$i=0;
		while($row = $db->fetchRow($ret)){
			$config = unserialize($row['configure']);
			if($config['shipping_fee'] <= 0){
				$ship_dec = "包邮";
			}elseif($config['free_money'] <= 0){
				$ship_dec = "加".$config['shipping_fee']."元运费";
			}else{
				$ship_dec = "不足".$config['free_money']."元,加".$config['shipping_fee']."元运费";
			}
			$selected = '';
			if($i==0){
				$selected = 'selected';
				$order['shipping_pay'][$suppid] = $row['fee_id'];//记录第一个被选中的配送方式的id
			}
			$select_html .= "<option ".$selected." value=".$row['fee_id']." >".$row['shipping_name']."[".$ship_dec."]</option>";
			$i++;
		}
	}else{
		$select_html .= "<option value='0'>暂不支持收货地址配送</option>";
	}
	$select_html .= "</select>";
	$_SESSION['flow_order'] = $order;//保存到session中
	return $select_html;
}

//app端专用方法
function insert_get_shop_shipping_app($arr){
	global $db,$ecs;
	$order = $_SESSION['flow_order'];//获取订单信息
	$suppid = intval($arr['suppid']);
	$stock_type = 0;
	if($suppid>0){
		$stock_type = $db->getOne("select type from ".$ecs->table("store_type")." where supplier_id=".$suppid);
	}
	$where = '';
	foreach($_REQUEST['datainfo'] as $k=>$v){
		$where .= " and ".$v."=".$_COOKIE['region_'.$k];
	}
	$select_html = "<select class='select_ziti' name='pay_ship[".$suppid."]' id='pay_ship_".$suppid."' onchange='selectShipping(this.value,".$suppid.");' title='".$suppid."' >";
	$sql = "select s.shipping_name,ssf.fee_id,ssf.configure from ".$ecs->table("store_shipping_region")." as ssr,".$ecs->table("store_shipping_fee")." as ssf,".$ecs->table("shipping")." as s where ssr.supplier_id=".$stock_type.$where." and ssr.rec_id=ssf.shipping_region_id and ssf.shipping_id=s.shipping_id";
	$isZhiChi = $db->getRow($sql);
	$ret = $db->query($sql);
	if($ret && $isZhiChi){
		$i=0;
		while($row = $db->fetchRow($ret)){
			$config = unserialize($row['configure']);
			if($config['shipping_fee'] <= 0){
				$ship_dec = "包邮";
			}elseif($config['free_money'] <= 0){
				$ship_dec = "加".$config['shipping_fee']."元运费";
			}else{
				$ship_dec = "不足".$config['free_money']."元,加".$config['shipping_fee']."元运费";
			}
			$selected = '';
			if($i==0){
				$selected = 'selected';
				$order['shipping_pay'][$suppid] = $row['fee_id'];//记录第一个被选中的配送方式的id
			}
			$select_html .= "<option ".$selected." value=".$row['fee_id']." >".$row['shipping_name']."[".$ship_dec."]</option>";
			$i++;
		}
	}else{
		$select_html .= "<option value='0'>暂不支持收货地址配送</option>";
	}
	$select_html .= "</select>";
	$_SESSION['flow_order'] = $order;//保存到session中
	return $select_html;
}


// morestock_morecity end
?>