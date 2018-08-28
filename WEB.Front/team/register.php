
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册中心！</title>
<link rel="stylesheet" href="/css/nsc/reset.css?v=1.16.11.8" />


<link href="/js/nsc/dialogUI/dialogUI.css?v=1.16.11.8" media="all" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="/static/add/css/font-awesome.min.css">
<link rel="stylesheet" href="/static/add/css/anmite.css">
<link type="text/css" rel="stylesheet" href="/static/add/css/waves.min.css" />
<link type="text/css" rel="stylesheet" href="/static/add/css/register.css" />
<script type="text/javascript" src="/js/nsc/jquery-1.7.min.js?v=1.16.11.8"></script>
<script type="text/javascript" src="/js/nsc/dialogUI/jquery.dialogUI.js?v=1.16.11.8"></script>
<script type="text/javascript" src="/js/nsc/common.js?v=1.16.11.8"></script>
<script type="text/javascript" src="/skin/main/onload.js"></script>
<script type="text/javascript" src="/skin/main/reglogin.js"></script>
<script type="text/javascript" src="/skin/main/game.js"></script>
<script type="text/javascript">window.onerror=function(){return true;}</script>

<script language="javascript">
document.onkeydown = function(event){if ((event.keyCode == 112) || //屏蔽 F1
                    (event.keyCode == 113) || //屏蔽 F2
                    (event.keyCode == 114) || //屏蔽 F3
                    (event.keyCode == 115) || //屏蔽 F4
                    (event.keyCode == 116) || //屏蔽 F5
                    (event.keyCode == 117) || //屏蔽 F6
                    (event.keyCode == 118) || //屏蔽 F7
                    (event.keyCode == 119) || //屏蔽 F8
                    (event.keyCode == 120) || //屏蔽 F9
                    (event.keyCode == 121) || //屏蔽 F10
                    (event.keyCode == 122) || //屏蔽 F11
                    (event.keyCode == 123)) //屏蔽 F12
                    {
                    return false;
                }}
            window.onhelp = function(){return false;}
</script>

<script>
function stop(){
return false;
}
document.oncontextmenu=stop;
</script>

<script type="text/javascript">
function registerBeforSubmit(){
	var type=$('[name=type]:checked',this).val();
	if(!this.username.value) throw('请输入帐号');
	if(!/^\w{5,15}$/.test(this.username.value)) throw('帐号由5到15位的字母、数字及下划线组成');
	if(!this.password.value) throw('请输入密码');
	if(this.password.value.length<6) throw('登入密码至少6位');
	if(!this.cpasswd.value) throw('请输入确认密码');
	if(this.cpasswd.value!=this.password.value) throw('两次输入密码不一样');
	if(!this.qq.value) throw('请输QQ号码');
	if(!this.vcode.value) throw('请输入验证码');
}
function registerSubmit(err,data){
	if(err){
		$.alert(err);
		 $("#vcode").trigger("click");
	}else{
		$.alert(data);
		
		window.setTimeout("window.location='/index.php/user/login'",3000); 
		
	}
}
		document.onkeydown = keyDown;
		function keyDown(e){
			if(event.keyCode == 13){
				$(this).closest('form').submit()
			}
		}

</script> 

</head>
<body class="re-bg">

<div class="reg-content">
      <div class="logo animated fadeInDown"></div>
      <div class="reg-box  animated zoomIn">
        <div class="reg-center">
		<?php if($args[0]){ ?>
		 <form action="/index.php/user/reg" onkeydown="if(event.keyCode==13){return false;}"  method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax" id="reg_form">
			<input type="hidden" name="codec" value="<?=$args[0]?>" />
            <div class="login-input1">
              <div class="reg-name pull-left">用户名:</div>
              <div class="reg-input pull-right">
                <i class="fa fa-user"></i> 
                <input type="text" class="form-control" placeholder="请输入帐号" id="username"  name="username" onkeyup="value = value.replace(/[^\w\/]/ig, '');" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength="15" //>
              </div>
            </div>
            
            <div class="login-input2">
              <div class="reg-name pull-left">设置密码:</div>
              <div class="reg-input pull-right">
                <i class="fa fa-lock"></i> 				
                <input id="epwd" type="password" class="form-control" name="password" placeholder="请输入密码" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength="13"/>
              </div>
            </div>
            <div class="login-input3">
              <div class="reg-name pull-left">确认密码:</div>
              <div class="reg-input pull-right">
                <i class="fa fa-lock"></i> 
                <input type="password" class="form-control" id="checkpwd" name="cpasswd" placeholder="请确认密码" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength="13"/>
              </div>
            </div>
			<div class="login-input4">
              <div class="reg-name pull-left">QQ号码:</div>
              <div class="reg-input pull-right">
                <i class="fa fa-user"></i> 
				<input type="text" name="qq" id="qq" class="form-control" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]/,'');}).call(this)" maxLength=11 placeholder="请输入QQ号码">
              </div>
            </div>
            <div class="login-input5">
              <div class="reg-name pull-left">验证码:</div>
              <div class="reg-input pull-right">
                <i class="fa fa-picture-o"></i> 
				<input type="text" name="vcode" id="vcode" class="form-control code-input pull-left" style="width:80px;" placeholder="验证码" maxLength=4 onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9]/,'');}).call(this)" onblur="this.v();">
                <div class="code-img pull-right">
				<img  onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()" title="点击刷新" style="cursor:pointer; border: 0px solid #999; vertical-align:middle;height: 35px;width: 65px;" src="/index.php/user/vcode/<?=$this->time?>" class="zc_code">
                </div>
              </div>
            </div>
            <div class="login-input6">
				<p class="reg-btn">
					<input type="submit" class="" value="注  册">
				</p>
				
            </div>
          </form>
		  
		<?php }else{?> 
		<div id="error">
			<h3>
				<font class="hint_red">无效的推广链接！</font>
			</h3>
			
		</div>
		<?php }?>
        </div>
      </div>
    </div>
    <div id="footer"></div>


<script src="/static/add/js/bootstrap.min.js"></script>
<script>
 var $ft = $('#footer'),
                minH = $ft.offset().top + $ft.outerHeight();
        function loginResponsive() {
          var bh = $(window).height();
          if (bh > minH) {
            $ft.css({
              marginTop: bh - minH
            });
          }
        }
</script>
</body>
</html>


