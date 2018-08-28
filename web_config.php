<?php
require_once('web_sqlin.php');
$conf['debug']['level']=5;

/*		数据库配置		*/
$conf['db']['dsn']='mysql:host=116.206.92.137;dbname=dasheng;charset=utf8';
$dbname='dasheng';
$dbhost='116.206.92.137';
$conf['db']['user']='dasheng';
$conf['db']['password']='www.123.com';  
$conf['db']['charset']='utf8';
$conf['db']['prename']='z4r5jk12_';

$conf['cache']['expire']=0;
$conf['cache']['dir']='_Y6f9=jyyB9.c,ER#-u/';

$conf['url_modal']=2;

$conf['action']['template']='WEB.Front/';
$conf['action']['modals']='WEB.Back/';

$conf['member']['sessionTime']=15*60;	// 用户有效时长
$conf['node']['access']='http://116.206.92.180:65531';	
error_reporting(E_ERROR & ~E_NOTICE);

ini_set('date.timezone', 'PRC');

ini_set('display_errors', 'Off');

if(strtotime(date('Y-m-d',time()))>strtotime(date('Y-m-d',time()))){
	$GLOBALS['fromTime']=strtotime(date('Y-m-d',strtotime("-1 day")));
	$GLOBALS['toTime']=strtotime(date('Y-m-d',time()));
}else{
	
	$GLOBALS['fromTime']=strtotime(date('Y-m-d'));
	$GLOBALS['toTime']=strtotime(date('Y-m-d',strtotime("+1 day")));
}
?>
<?php
error_reporting(0);
$config = mysql_connect("116.206.92.137","dasheng","www.123.com")or die("Mysql Connect Error");//设置数据库IP，账号，密码
mysql_select_db("dasheng");//数据库库名
mysql_query("SET NAMES UTF8");
?>
