<?php
$company_id='436';
$company_api_key= 'fwIuH4NK6BzxFL0DuTljkWsU0r1bctYm9WRz3GzIzg5n2tSkxDKhMl2u0MJuxnSD';
$amount=$_POST['p3_Amt'];
$order_id=$_POST['p2_Order'];
$player_username=$_POST['pa_MP'];

 $data = "cid=" . $company_id . "&uid=" . $player_username . "&time=" . time() . "&amount=" . $amount . "&order_id=" . $order_id . "&ip=" . $_SERVER['REMOTE_ADDR'];
        $dig64 =  base64_encode(hash_hmac('sha1', $data, $company_api_key, true));
        $reqdata = $data . "&sign=" . $dig64;echo $dig64;
        $url =  "https://www.dsdfpay.com/dsdf/customer_pay/init_din?" . $reqdata;
		
		
		
	
		
        header("Location:" . $url);


?>