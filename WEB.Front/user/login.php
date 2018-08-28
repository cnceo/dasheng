<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <title><?=$this->settings['webName']?>官方网站</title>

	
	  <link rel="stylesheet" href="/css/nsc/reset.css?v=1.16.11.5" />
    <link rel="stylesheet" href="/css/nsc/plugin/dialogUI/dialogUI.css?v=1.16.11.5" media="all" type="text/css" >
    <link rel="stylesheet" type="text/css" media="all" href="/js/keypad/keypad.css?v=1.16.11.5" />
    <link rel="stylesheet" href="/css/nsc/login.css?v=1.16.11.5" />
	<!---->
	<script type="text/javascript" src="/js/nsc/jquery-1.7.min.js?v=1.16.11.5"></script>
	<link href="/static/add/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/static/add/css/font-awesome.min.css">
	<link rel="stylesheet" href="/static/add/css/anmite.css">
	<link rel="stylesheet" href="/static/add/css/swiper-3.4.2.min.css">
	<link type="text/css" rel="stylesheet" href="/static/add/css/login.css">
	<!--/--->
	
    
	
	<script type="text/javascript" src="/static/add/js/layer.js"></script>
	
	
    <script type="text/javascript" src="/js/common/jquery.md5.js?v=1.16.11.5"></script>
    <script type="text/javascript" src="/js/nsc/dialogUI/jquery.dialogUI.js?v=1.16.11.5"></script>
    <script type="text/javascript" src="/js/nsc/dialogUI/jquery.dragdrop.js?v=1.16.11.5"></script>
    <script language="javascript" type="text/javascript" src="/js/common/jquery.md5.js?v=1.16.11.5"></script>
    <script type="text/javascript" src="/js/keypad/jquery.keypad.js?v=1.16.11.5"></script>
    <script type="text/javascript" src="/js/nsc/login.js?v=1.16.11.5"></script>
	<script type="text/javascript" src="/images/down/swfobject.js?v=1.16.11.5"></script>
	<script type="text/javascript" src="/skin/main/onload.js"></script>
	<script type="text/javascript" src="/skin/main/reglogin.js"></script>

<style>
.swiper-button-next, .swiper-button-prev{height: 20px;}
.swiper-pagination-bullet{background: #fff;
    opacity: 1;
	width: 30px;
    height: 4px;
    border-radius: 0;
}
.swiper-pagination-bullet-active {
    background: #007aff;
}
</style>
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
<!--201709071436-->
   
<script>    	
        $(function() {
            $(".browser_box div").hover(function () {
                $(this).addClass($(this).attr("class") + "_curr").stop(true).animate({
                    right: "0px",
                    width: "100px"
                }).find(".text").show();
				//}).find(".text").show(5);
            }, function () {
                $(this).removeClass($(this).attr("class").split(' ')[0] + "_curr").stop(true).animate({
                    right: "0px",
                    width: "0px"
                }, function () {
                    $(this).find(".text").hide();
                })
            });

            /*如果可视区域小于960进行适配*/
            function checkWidth(){
                var _ww = $(window).width(),_dw = $(document).width(),_scrollLeft;
                _scrollLeft = _dw - _ww;
                if(_ww <= 960){
                    $(document).scrollLeft(_scrollLeft);
                }
            }
            //checkWidth(2);
            $(window).resize(function(){
                //checkWidth(7);
            });

            (function(){
        var html;
        var fnCheckIes = function(v){
            var broswer = navigator.userAgent;
            var ver = parseInt(broswer.substr(broswer.indexOf("MSIE")+5,3));
            if(broswer.indexOf("MSIE") != -1){
                if(ver <= v){
                    return 1;
                }else{
                    return 2;
                }
            }else if(broswer.indexOf("Firefox") != -1){
                return "firefox";
            }else if(broswer.indexOf("rv:11") != -1){
                return 11;
            }else{
                return 3;
            }

        }
       
    
    })();
        })    
    </script>
</head>

<body  class="signup-page">
	<div id="container"><div id="output"><canvas width="100%" height="923px" style="display: block;"></canvas></div></div>
	
	<div class="container login">
		<div class="row">
			<div class="col-lg-1 col-md-1 col-sm-0"></div>
			
			<div class="col-lg-10 col-md-10 col-sm-12">
				<div class="logo animated fadeInDown"><img alt="<?=$this->settings['webName']?>" src="/images/nsc/logo.png"></div>
				<div class="login-box animated zoomIn">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<form action="/index.php/user/logined" method="post" onajax="userBeforeLogin" enter="true" id="signupForm" call="userLogin" target="ajax">
									<h4>会员登录</h4>
									<label class="login-input">
										<i class="fa fa-user"></i>
										<input type="text" placeholder="输入用户名" id="username" class="form-control" name="username">
									</label>
									
									<label class="login-input">
										<i class="fa fa-lock"></i>
										<input type="password" value="" id="password" class="form-control" name="password" placeholder="输入登录密码">
									</label>
									
									<label class="login-input">
										<i class="fa fa-picture-o"></i>
										<input type="text" id="vcode" value="" class="form-control code-input pull-left" name="vcode" maxlength="4" placeholder="输入验证码" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
										<span class="code-img pull-right">
											<img title="点击刷新" style="cursor:pointer; border: 0" class="code" id="dvcode" src="/index.php/user/vcode/1501176004" onClick="this.src='/index.php/user/vcode/'+(new Date()).getTime()">
										</span>
									</label>
									<button id="login" class="btn btn-info login-btn" onclick="$(this).closest('form').submit();return false;">登 录</button>
									
									<!--a href="/index.php/user/r/5E5F5D" class="btn btn-info login-btn">点我注册</a-->
								</form>
							</div>
						</div>
						
						<div class="col-lg-8 col-md-8 col-sm-12"></div>
						<div class="col-lg-8 col-md-8 col-sm-12"></div>
						<div class="col-lg-8 col-md-8 col-sm-12"></div>
						<div class="col-lg-8 col-md-8 col-sm-12">
							<div class="swiper-container" style="height:300px;">
								<div class="swiper-wrapper">
									<div class="swiper-slide"><img src="/static/add/images/1.png"></div>
									<div class="swiper-slide"><img src="/static/add/images/2.png"></div>
									<div class="swiper-slide"><img src="/static/add/images/3.png"></div>
									<div class="swiper-slide"><img src="/static/add/images/4.png"></div>
								</div>
								<!-- 如果需要分页器 -->
								<div class="swiper-pagination"></div>
								
								<!-- 如果需要导航按钮 -->
								<div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>

							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
    





<script src="/static/add/js/bootstrap.min.js"></script>
<script src="/static/add/js/swiper-3.4.2.min.js"></script>
<script src="/static/add/js/vector.js"></script>
<script>
$(function () {
var victor = new Victor("container", "output");
var theme = [
["#000", "#333"]
]
$(".color li").each(function (index, val) {
var color = theme[index];
$(this).mouseover(function () {
victor(color).set();
})
});
});
</script>
<script>
var mySwiper = new Swiper ('.swiper-container', {
    loop: true,
    autoplay: 3000,//可选选项，自动滑动
    // 如果需要分页器
    pagination: '.swiper-pagination',
    
    // 如果需要前进后退按钮
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    
  })        
</script>
<script type="text/javascript">
$(function () {
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
loginResponsive();
});
</script>
<script type="text/javascript">
 function zxkf(){
	<?php if($this->settings['kefuStatus']){ ?>
	var newWin=window.open("<?=$this->settings['kefuGG']?>","","height=600, width=800, top=0, left=0,toolbar=no, menubar=no, scrollbars=no, resizable=no, location=n o, status=no");
	if(!newWin||!newWin.open||newWin.closed){newWin=window.open('about:blank');}else{return false;}
	<?php }else{?>
	$.alert("客服系统维护中");
	<?php }?>
	return false;
 }
function qqkf(){
	<?php if($this->settings['qqkefuStatus']){ ?>
	var newWin=window.open("http://wpa.qq.com/msgrd?uin=<?=$this->settings['qqkefuGG']?>&site=qq&menu=yes","","height=600, width=800, top=0, left=0,toolbar=no, menubar=no, scrollbars=no, resizable=no, location=n o, status=no");
	if(!newWin||!newWin.open||newWin.closed){newWin=window.open('about:blank');}else{return false;}
	<?php }else{?>
	$.alert("客服系统维护中");
	<?php }?>
	return false;
}
</script> 


</body>
</html>