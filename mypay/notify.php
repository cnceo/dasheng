<?php
 $res= json_decode( file_get_contents("php://input"),true);

 $data['orderNo']=$res['order_id'];
 $data['merchParam']=$res['customer_name'];
  $data['tradeAmt']=$res['amount']/100;
  //$data['tradeAmt']=$res['amount'];
  
  
  
  
  
 	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
$conn = mysql_connect('116.206.92.137','dasheng','www.123.com');//////
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db('dasheng',$conn);






mysql_query("SET NAMES UTF8");
$chaxun = mysql_query("SELECT state FROM z4r5jk12_order WHERE order_number = '".$data['orderNo']."'");
$jiancha = mysql_result($chaxun,0);
$chaxun2 = mysql_query("select actionIP from z4r5jk12_member_recharge where rechargeid= '".$data['orderNo']."'");
$actionIP = mysql_result($chaxun2,0);
$chaxun3 = mysql_query("select id from z4r5jk12_member_recharge where rechargeid= '".$data['orderNo']."'");
$id = mysql_result($chaxun3,0);
$chaxun4 = mysql_query("select uid from z4r5jk12_member_recharge where rechargeid= '".$data['orderNo']."'");
$uid = mysql_result($chaxun4,0);
$chaxun5 = mysql_query("select coin from z4r5jk12_members where username= '".$data['merchParam']."'");
$coin = mysql_result($chaxun5,0);
$chaxun6 = mysql_query("select value from z4r5jk12_params where name='czzs'");
$czzs = mysql_result($chaxun6,0);
if($czzs){
	$r3_Amt=$r3_Amt*(1+number_format($czzs/100,2,'.',''));
}
$inserts = "insert into z4r5jk12_coin_log (uid,type,playedId,coin,userCoin,fcoin,liqType,actionUID,actionTime,actionIP,info,extfield0,extfield1) values ('".$uid."',0,0,'".$data['tradeAmt']."','".$coin."'+'".$data['tradeAmt']."',0,1,0,UNIX_TIMESTAMP(),'".$actionIP."','在线支付自动到账','".$id."','".$uid."')";
$update1 = "UPDATE z4r5jk12_order SET state = 2 WHERE order_number = '".$data['orderNo']."'";
$update2 = "UPDATE z4r5jk12_members SET coin = coin+'".$data['tradeAmt']."' WHERE username = '".$data['merchParam']."'";
$update3 = "update z4r5jk12_member_recharge set state=2,rechargeTime='".time()."',rechargeAmount='".$data['tradeAmt']."',coin='".$coin."', info='在线支付自动到账' where rechargeid='".$data['orderNo']."'";

//echo $update3;

if($jiancha==0){
	   
                if(mysql_query($update1,$conn)){
                mysql_query($update2,$conn);
                mysql_query($update3,$conn);
                mysql_query($inserts,$conn);
				echo 'true';
               // echo "您已成功充值，请重新登陆平台界面查看,谢谢!";
				}else{
					echo "false";
				}
	     
}else{
    echo "true";
	exit;
}
mysql_close($conn);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	


 
 
 
 
 
 
//$myfile = fopen("newfiless.txt", "w") or die("Unable to open file!");
//fwrite($myfile,var_export( $res,true));
//fclose($myfile);
?>
