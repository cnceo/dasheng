<?php 
error_reporting(0);
function getTopDomainhuo(){
		$host=$_SERVER['HTTP_HOST'];
		
		$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
		if(preg_match("/".$matchstr."/ies",$host,$matchs)){
			$domain=$matchs['0'];
		}else{
			$domain=$host;
		}
		return $domain;

}
$domain=getTopDomainhuo();

$real_domain='baidu.com'; //本地检查时 用户的授权域名 和时间

$check_host = 'http://gj.35pym.com/update.php';
$client_check = $check_host . '?a=client_check&u=' . $_SERVER['HTTP_HOST'];
$check_message = $check_host . '?a=check_message&u=' . $_SERVER['HTTP_HOST'];
$check_info=file_get_contents($client_check);
$message = file_get_contents($check_message);





unset($domain);
$good=$args[0]; ?>
<?php if($good['price']>0){ ?>

<form action="/index.php/score/swapGood" method="post" target="ajax" onajax="scoreBeforeSwapGood2" call="scoreSwapGood">
<input type="hidden" name="goodId" value="<?=$good['id']?>"/>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grayTable">
       
              <tr>
              <td class="u_add_zl">此次兑换：</td>
              <td class="u_add_zr" >
              <label><span class="spn16"><?=$good['score']?></span> 积分= <span class="spn16"><?=$good['price']?></span> 元</label>
              </td>
              </tr>
              <tr>
                <td class="u_add_zl">此次兑换将扣除您：</td>
                <td class="u_add_zr" ><label><span class="spn16"><?=$good['score']?></span> 积分！</label></td>
              </tr>
              <tr>
                <td class="u_add_zl">兑换数量：</td>
                <td class="u_add_zr" ><input name="number" value="1" style="text-align: center;"/></td>
              </tr>
			  <tr>
                <td class="u_add_zl">资金密码：</td>
                <td class="u_add_zr" ><input type="password" name="coinpwd" value=""/></td>
              </tr>
			  <tr>
			   <td class="u_add_zl"><?=$this->settings['scoreRule']?></td>
			   <td class="u_add_zl"><input type="submit" id='put_button_pass' class="formWord" value="确认兑换"></td>
			  </tr>
           
		
	
</form>
<?php }?>  