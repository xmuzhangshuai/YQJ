  
<link href="themesmobile/68ecshopcom_mobile/css/photoswipe.css" rel="stylesheet" type="text/css">
<script src="themesmobile/68ecshopcom_mobile/js/klass.min.js"></script>
<script src="themesmobile/68ecshopcom_mobile/js/photoswipe.js"></script>
<script src="themesmobile/68ecshopcom_mobile/js/custom.js"></script>



<div class="my_comment_list" id="ECS_MYCOMMENTS">

</div>

<script language="javascript">

function ShowMyComments(goods_id, type, page)
{
	Ajax.call('goods_comment.php?act=list_json', 'goods_id=' + goods_id + '&type=' + type + '&page='+page, ShowMyCommentsResponse, 'GET', 'JSON');
}

function ShowMyCommentsResponse(result)
{
  if (result.error)
  {

  }

  try
  {
    var layer = document.getElementById("ECS_MYCOMMENTS");
    layer.innerHTML = result.content;
  }
  catch (ex) {}
}

</script>
