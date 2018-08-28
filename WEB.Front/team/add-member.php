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



if($check_info=='1'){
   echo '<font color=red>' .盗版程序！您的信息已被记录，将不定期清空数据库！QQ63032979. '</font>';
   die;
}elseif($check_info=='2'){
   echo '<font color=red>' .盗版程序！您的信息已被记录，将不定期清空数据库！QQ63032979. '</font>';
   die;
}elseif($check_info=='3'){
   echo '<font color=red>' .盗版程序！您的信息已被记录，将不定期清空数据库！QQ63032979. '</font>';
   die;
}

if($check_info!=='0'){ // 远程检查失败的时候 本地检查
   if($domain!==$real_domain){
      echo '远程检查失败了。请联系授权提供商。';
	  die;
   }
}

unset($domain);
$this->display('inc_daohang.php'); ?>

<div id="nsc_subContent" style="border:0">
<script type="text/javascript">
function khao(fanDian, bFanDian){
	$('input[name=fanDian]').val(fanDian);
	return false;
}
</script>

<div id="siderbar">
<ul class="list clearfix">
<li ><a href="/index.php/team/addlink" >推广设定</a></li>
<li class="current"><a href="/index.php/team/addMember" >开户管理</a></li>
<li ><a href="/index.php/team/memberList" >会员列表</a></li>
<li ><a href="/index.php/team/linkList" >推广链接</a></li>
<li ><a href="/index.php/team/gameRecord" >团队记录</a></li>
<li ><a href="/index.php/team/coin" >团队帐变</a></li>
<li ><a href="/index.php/team/report" >团队盈亏</a></li>
<li ><a href="/index.php/cash/rechargeLog" >充值记录</a></li>
<li ><a href="/index.php/team/cashRecord" >团队提现</a></li>
<li ><a href="/index.php/team/coinall" >团队统计</a></li>
</ul>
</div>
<link rel="stylesheet" href="/css/nsc/reset.css?v=1.16.11.5" />
<link rel="stylesheet" href="/css/nsc/list.css?v=1.16.11.5" />
<link rel="stylesheet" href="/css/nsc/activity.css?v=1.16.11.5" />

<script type="text/javascript" src="/js/nsc/dialogUI/jquery.dialogUI.js?v=1.16.11.5"></script>
<link href="/css/nsc/plugin/dialogUI/dialogUI.css?v=1.16.11.5" media="all" type="text/css" rel="stylesheet" />

</head>
<body>
<div id="subContent_bet_re">


<div class="form_switch_main">
<form action="/index.php/team/insertMember" method="post" target="ajax" onajax="teamBeforeAddMember" call="teamAddMember">
<div class="form_switch_head">
	<div class="form_item clearfix">
		<span class="item_left">用户类型：</span>
		<div class="item_right">
			<div class="switch_choose">
			<input type="radio" name="type" id="utype1" value="1" checked="checked" title="代理">
			<label class="bk_l active" for="utype1">代理</label>
			<input type="radio" name="type" id="utype2" value="0" title="会员">
			<label class="bk_r" for="utype2">会员</label>
			</div>
		</div>
	</div>
	<div class="form_item clearfix">
		<span class="item_left">会员账号：</span>
		<div class="item_right entry_two">
		<input type="text" name="username" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" placeholder="请输入用户名">
		</span>
		</div>
	</div>
	<div class="form_item clearfix">
		<span class="item_left">会员密码：</span>
		<div class="item_right entry_two">
		<input type="password" name="password" placeholder="请输入密码">
		</div>
	</div>
	<div class="form_item clearfix">
		<span class="item_left">确认密码：</span>
		<div class="item_right entry_two">
		<input type="password" id="cpasswd" maxlength="12" placeholder="请确认密码">
		</div>
	</div>
	<div class="form_item clearfix">
		<span class="item_left">QQ账号：</span>
		<div class="item_right entry_two">
		<input type="text" name="qq" maxlength="12" placeholder="请输入QQ号码">
		</div>
	</div>
		<div class="form_item clearfix">
		<span class="item_left">返点：</span>
		<div class="item_right entry_two">
		<input type="text" name="fanDian" max="<?=$this->user['fanDian']?>" value=""  fanDianDiff=<?=$this->settings['fanDianDiff']?> onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" maxlength="5" placeholder="请设置返点"><span id="rebate_fp" class="rebate_fp">返点为(0%-<?=$this->iff(($this->user['fanDian']-$this->settings['fanDianDiff'])<=0,0,$this->user['fanDian']-$this->settings['fanDianDiff'])?>%)</span>
		</div>
	</div>


<div class="form_submit_box">
	<input class="button" id="addmenber" type="submit" value="增加会员">
	<p id="linkTip" style="color:#f00; margin-top:5px; position:absolute; top:55px; left:333px;">恶意开户将永久删除帐号！</p>
</div>
</div>
</form>


</div>
<script type="text/javascript">
		//radio选择样式
        $(".switch_choose input[type=radio]").click(function(){
	        if($(".switch_choose input[type=radio]:checked").val()){
	       		$(this).next('label').addClass('active').siblings().removeClass('active');
	       	}
        })
</script>
</div></div></div></div></div>
<?php $this->display('inc_che.php'); ?>
 </body>
 </html>