
<script type="text/javascript">
function showDiv(rec_id, inout_status, action_val)
{
document.getElementById('popDiv').style.display='block';
document.getElementById('bg').style.display='block';
var form_inout_check = document.forms['inout_check'];
form_inout_check.elements['action_val'].value = action_val;
form_inout_check.elements['inout_status'].value = inout_status;
form_inout_check.elements['rec_id'].value = rec_id;
}

function closeDiv(){
document.getElementById('popDiv').style.display='none';
document.getElementById('bg').style.display='none';
var sels = document.getElementsByTagName('select'); 
 for (var i = 0; i < sels.length; i++) 
    {
		sels[i].style.visibility = '';     

    }
}




</script>


<div id="popDiv" class="mydiv" style="display:none;">

<div class="qb_left">&nbsp;&nbsp;填写备注</div><div class="qb_right" ><a href="javascript:closeDiv()" >关 闭</a>&nbsp;&nbsp;&nbsp;</div>
<div style="clear:both;"></div>
<form  method="post" name="pricecut_notice" id="inout_check" action="<?php if ($this->_var['script_file']): ?><?php echo $this->_var['script_file']; ?><?php else: ?>store_inout_in.php<?php endif; ?>" > 
<table cellpadding=0 cellspacing=0 width="90%" border=0>  
    <tr><td colspan=2 height=30>&nbsp;</td></tr>
    <tr> 
      <td valign="top" align="right">填写备注：</td> 
      <td  align="left"> <textarea rows=10 cols=60 name="note"></textarea></td> 
    </tr>   
    <tr> 
      <td colspan="2" align=center  style="padding:20px 0;"> 
	  <input type="hidden" value="" name="action_val" id="action_val">
	  <input type="hidden" value="" name="inout_status" id="inout_status">
      <input type="hidden" value="" name="rec_id" id="rec_id">
	  <input type="hidden" value="check_insert" name="act" >
      <input type="submit" class="botton" value="确定" > 
      </td>  
    </tr> </table> 

</form> 
</div>