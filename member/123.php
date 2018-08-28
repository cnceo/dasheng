<?php
include_once("../class/BiApi.class.php");
header("Content-type: text/html; charset=utf-8"); 
$ag_balance=0.00;
$game='AG';
$zztype = isset($_POST['zz_type']) ? $_POST['zz_type'] : '';
$user=$_GET['username'];
if($user=='')
{
	$user=$_POST['user'];
}
if($zztype == '11' || $zztype == '21'){
	$game='BB';
}
if($zztype == '12' || $zztype == '22'){
	$game='AG';
}
if($zztype == '13' || $zztype == '23'){
	$game='MW';
}
$yue= new Biapi();
$ag_balance=$yue->balances('AG',$user);
$bb_balance=$yue->balances('BB',$user);
$mw_balance=$yue->balances('MW',$user);
if($ag_balance=='用户不存在'){
	$ag_balance=0;
	$yue->loginbi($game,$user);
}
if($bb_balance=='用户不存在'){
	$bb_balance=0;
	$yue->loginbi('BB',$user);
}
if($mw_balance=='用户不存在'){
	$mw_balance=0;
	$yue->loginbi('MW',$user);
}

if($_GET['ajax'] == 'yes'){
	$yue= new Biapi();
    $ag_balance=$yue->balances('AG',$user);
    $bb_balance=$yue->balances('BB',$user);
	echo json_encode(array('ag_balance'=>$ag_balance,'bb_balance'=>$bb_balance,'mw_balance'=>$mv_balance));
	exit;
} 
$zztype = isset($_POST['zz_type']) ? $_POST['zz_type'] : '';
$yy = isset($_POST['zz_money']) ? trim($_POST['zz_money']) : '';
include("../web_config.php");
$conn = mysql_connect($dbhost,$conf['db']['user'],$conf['db']['password']);
if (!$conn){
			die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname,$conn);
mysql_query("set names utf8");
$money=mysql_query("select coin from z4r5jk12_members where username= '".$user."'");
$conver = mysql_result($money,0);
if (($zztype=='12' || $zztype=='11'|| $zztype=='13') && ($yy> $conver ))
{
        echo '转账金额不能大于账户余额，请重新输入。';
        exit;
}
/* if (($zztype=='21' || $zztype=='22'|| $zztype=='23') && ($yy> $ag_balance ))
{
        echo '转账金额不能大于账户余额，请重新输入。';
        exit;
} */
 if($zztype == '11' || $zztype == '12' || $zztype == '13' ){
		$res=new Biapi();
		$result=$res->zzmoney($game,$user,'IN',$yy);
		if($result){//充值成功
			$res_money=$conver-$yy;
			$chongzhi="update ssc_members set coin=".$res_money." where username='".$user."'";
            mysql_query($chongzhi,$conn);
			echo '网站账号转入成功'.$yy.'元到真人娱乐账号';
			exit;
		}else{
			echo '转换失败1111';
			exit;
		}			
		}else if($zztype == '21' || $zztype == '22' || $zztype == '23' ){
			$res=new Biapi();
			$result=$res->zzmoney($game,$user,'OUT',$yy);
		    if($result){//提现成功
			$res_money=$conver+$yy;
			$tixian=mysql_query("update ssc_members set coin=".$res_money." where username='".$user."'");
            $conver = mysql_result($tixian,0);
			echo '真人娱乐账号转出成功'.$yy.'元到网站账号';
			exit;
	}else{
		echo '转换失败22222';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>额度转换</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link type="text/css" rel="stylesheet" href="images/member.css"/>
<script type="text/javascript" src="images/member.js"></script>
<script>
		var $my = function(id){
			return document.getElementById(id);
		}		
		//数字验证 过滤非法字符
        function clearNoNum(obj){
	        obj.value = obj.value.replace(/[^\d.]/g,""); //先把非数字的都替换掉，除了数字和.
	        obj.value = obj.value.replace(/^\./g,""); //必须保证第一个为数字而不是.
	        obj.value = obj.value.replace(/\.{2,}/g,"."); //保证只有出现一个.而没有多个.
	        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); //保证.只出现一次，而不能出现两次以上
	        if(obj.value != ''){
				var re=/^\d+\.{0,1}\d{0,2}$/;
				if(!re.test(obj.value))   
				{   
					obj.value = obj.value.substring(0,obj.value.length-1);
					return false;
				} 
	        }
        }
		
		function SubInfo(){
			$my('SubTran').value = "转账处理中";
			$my('SubTran').disabled = "disabled";
			$my('form1').submit();
		}
	</script>
	<script type="text/javascript" src="../skin/js/jquery-1.7.2.min.js"></script>
	<script language="javascript">
	    $("#SubTran").val('请稍后...')
	    $("#SubTran").attr('disabled',true);
	    $("#live_money_span").html('<img src="../Box/skins/icons/loading.gif" />');
	    $(function(){
		   $.getJSON('./zr_money.php?ajax=yes',function(data){
			   $('.ag_money').html(parseFloat(data.ag_balance) );
			   $('.bb_money').html(parseFloat(data.bb_balance) );
			   $('.mw_money').html(parseFloat(data.mw_balance) );
			   // $("#live_money_span").html(json.user_livemoney);
			   $("#SubTran").val('确认转账')
			   $("#SubTran").attr('disabled',false);
		   });

	    });


	</script>
</head>
<body>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;">
	<tr>
		<td colspan="2" align="center" valign="middle">
			
			<div class="content">
				<table width="98%" border="0" cellspacing="0" cellpadding="5">
					<tr>
						<td height="30" align="center" bgcolor="#FAFAFA" class="hong"><strong>账户内部额度转账</strong></td>
					</tr>
					<tr>
						<td align="left" bgcolor="#FFFFFF" style="line-height:22px;">
							<table width="100%" border="0" cellspacing="0" cellpadding="5">
								<form id="form1" name="form1" action="?save=ok" method="post">
								<tr>
									<td width="150" align="right" bgcolor="#FAFAFA">用户账号：</td>
									<td align="left"><?=$user?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">钱包额度：</td>
									<td align="left"><?=sprintf("%.2f",$conver)?></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">真人娱乐场额度：</td>
                                    <td align="left" class="hong">
									  [AG] <span  style="margin-right:10px"><?=$ag_balance?></span>
									   [BBIN] <span  style="margin-right:10px"><?=$bb_balance?></span>	
                                 									   
									</td> 
										
								</tr>
								<tr>
								<td align="right" bgcolor="#FAFAFA">转账选择：</td>
								<td align="left">
									<select name="zz_type" id="zz_type">
										<option value ="12">主账户==>AG</option>
										<option value ="11">主账户==>BBIN</option>
								
										<option value ="22">AG ==>主账户</option>
										<option value ="21">BBIN ==>主账户</option>
									
									</select></td>
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">转账金额：</td>
									<td align="left"><input name="zz_money" type="text" class="input_150" id="zz_money" onkeyup="clearNoNum(this);" maxlength="10" size="15"/></td>
									<input name="user" type="hidden" id="user" value="<?=$user?>">
								</tr>
								<tr>
									<td align="right" bgcolor="#FAFAFA">&nbsp;</td>
									<td align="left"><input name="SubTran" type="button"  id="SubTran" onclick="SubInfo();" value="请稍后..." disabled="disabled" /></td>
								</tr>
								</form>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>
</body>
</html>