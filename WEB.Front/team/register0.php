<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$this->settings['webName']?>-官方网站-用户注册</title>
<link rel="stylesheet" href="/css/nsc/reset.css?v=1.17.6.10" />
<link rel="stylesheet" href="/css/nsc/agency_register1.css?v=1.17.6.10" />
<link href="/js/nsc/dialogUI/dialogUI.css?v=1.17.6.10" media="all" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/js/nsc/jquery-1.7.min.js?v=1.17.6.10"></script>
<script type="text/javascript" src="/js/nsc/dialogUI/jquery.dialogUI.js?v=1.17.6.10"></script>
<script type="text/javascript" src="/js/nsc/common.js?v=1.17.6.10"></script>
<script type="text/javascript" src="/js/nsc/register.js?v=1.17.6.10"></script>
<script type="text/javascript">window.onerror=function(){return true;}</script>
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
<script type="text/javascript">
var jsonParse = (function () {
    var number
        = '(?:-?\\b(?:0|[1-9][0-9]*)(?:\\.[0-9]+)?(?:[eE][+-]?[0-9]+)?\\b)';
    var oneChar = '(?:[^\\0-\\x08\\x0a-\\x1f\"\\\\]'
        + '|\\\\(?:[\"/\\\\bfnrt]|u[0-9A-Fa-f]{4}))';
    var string = '(?:\"' + oneChar + '*\")';

    // Will match a value in a well-formed JSON file.
    // If the input is not well-formed, may match strangely, but not in an unsafe
    // way.
    // Since this only matches value tokens, it does not match whitespace, colons,
    // or commas.
    var jsonToken = new RegExp(
        '(?:false|true|null|[\\{\}\\[\\]]'
            + '|' + number
            + '|' + string
            + ')', 'g');

    // Matches escape sequences in a string literal
    var escapeSequence = new RegExp('\\\\(?:([^u])|u(.{4}))', 'g');

    // Decodes escape sequences in object literals
    var escapes = {
        '"': '"',
        '/': '/',
        '\\': '\\',
        'b': '\b',
        'f': '\f',
        'n': '\n',
        'r': '\r',
        't': '\t'
    };
    function unescapeOne(_, ch, hex) {
        return ch ? escapes[ch] : String.fromCharCode(parseInt(hex, 16));
    }

    // A non-falsy value that coerces to the empty string when used as a key.
    var EMPTY_STRING = new String('');
    var SLASH = '\\';

    // Constructor to use based on an open token.
    var firstTokenCtors = { '{': Object, '[': Array};

    var hop = Object.hasOwnProperty;

    return function (json, opt_reviver) {
        // Split into tokens
        var toks = json.match(jsonToken);
        // Construct the object to return
        var result;
        var tok = toks[0];
        var topLevelPrimitive = false;
        if ('{' === tok) {
            result = {};
        } else if ('[' === tok) {
            result = [];
        } else {
            // The RFC only allows arrays or objects at the top level, but the JSON.parse
            // defined by the EcmaScript 5 draft does allow strings, booleans, numbers, and null
            // at the top level.
            result = [];
            topLevelPrimitive = true;
        }

        // If undefined, the key in an object key/value record to use for the next
        // value parsed.
        var key;
        // Loop over remaining tokens maintaining a stack of uncompleted objects and
        // arrays.
        var stack = [result];
        for (var i = 1 - topLevelPrimitive, n = toks.length; i < n; ++i) {
            tok = toks[i];

            var cont;
            switch (tok.charCodeAt(0)) {
                default:  // sign or digit
                    cont = stack[0];
                    cont[key || cont.length] = +(tok);
                    key = void 0;
                    break;
                case 0x22:  // '"'
                    tok = tok.substring(1, tok.length - 1);
                    if (tok.indexOf(SLASH) !== -1) {
                        tok = tok.replace(escapeSequence, unescapeOne);
                    }
                    cont = stack[0];
                    if (!key) {
                        if (cont instanceof Array) {
                            key = cont.length;
                        } else {
                            key = tok || EMPTY_STRING;  // Use as key for next value seen.
                            break;
                        }
                    }
                    cont[key] = tok;
                    key = void 0;
                    break;
                case 0x5b:  // '['
                    cont = stack[0];
                    stack.unshift(cont[key || cont.length] = []);
                    key = void 0;
                    break;
                case 0x5d:  // ']'
                    stack.shift();
                    break;
                case 0x66:  // 'f'
                    cont = stack[0];
                    cont[key || cont.length] = false;
                    key = void 0;
                    break;
                case 0x6e:  // 'n'
                    cont = stack[0];
                    cont[key || cont.length] = null;
                    key = void 0;
                    break;
                case 0x74:  // 't'
                    cont = stack[0];
                    cont[key || cont.length] = true;
                    key = void 0;
                    break;
                case 0x7b:  // '{'
                    cont = stack[0];
                    stack.unshift(cont[key || cont.length] = {});
                    key = void 0;
                    break;
                case 0x7d:  // '}'
                    stack.shift();
                    break;
            }
        }
        // Fail if we've got an uncompleted object.
        if (topLevelPrimitive) {
            if (stack.length !== 1) {throw new Error();}
            result = result[0];
        } else {
            if (stack.length) {throw new Error();}
        }

        if (opt_reviver) {
            var walk = function (holder, key) {
                var value = holder[key];
                if (value && typeof value === 'object') {
                    var toDelete = null;
                    for (var k in value) {
                        if (hop.call(value, k) && value !== holder) {
                            var v = walk(value, k);
                            if (v !== void 0) {
                                value[k] = v;
                            } else {
                                // Deleting properties inside the loop has vaguely defined
                                // semantics in ES3 and ES3.1.
                                if (!toDelete) {toDelete = [];}
                                toDelete.push(k);
                            }
                        }
                    }
                    if (toDelete) {
                        for (var i = toDelete.length; --i >= 0;) {
                            delete value[toDelete[i]];
                        }
                    }
                }
                return opt_reviver.call(holder, key, value);
            };
            result = walk({'': result}, '');
        }

        return result;
    };
})();
    $(function() {
        
         var checkFunc = (function(){
     	
     	$("input[name='username']").blur(function(){
        	var uname = $(this).val();
            var nickname = $("input[name='nickname']").val();
            if (uname != '' && nickname !='' && uname == nickname) {
                tip("nickname","error",'不可与用户名相同');
            } else {
                if(uname == "")
                {       
                    var message = "用户名不能为空";
                    tip("username","error",message);
                }else{
                    var re = /(\w)*(\w)\2{3}(\w)*/g;
                    if(!re.test(uname)){
                        var re1 = /^[^Oo0]/;
                        if(re1.test(uname))
                        {
                            var re2 = /^[a-zA-Z0-9]{6,16}$/;
                            if(!re2.test(uname)){
                                var message = "请输入由字母或数字组成的6-16位字符";
                                tip("username","error",message);
                            }else{
                                var url= 'http://'+window.location.host + '/?controller=default&action=checkcode';
                                var rq_post = {};
                                rq_post['flag']   = 'checkName';
                                rq_post['uname']  = uname;
                                rq_post['Submit'] = 'json';
                                $.post(url, rq_post, function(data){
                                    var json = jsonParse(data);
                                    var sMsg = json['sMsg']
                                    var sError = json['sError'];
                                    switch(sError){
                                        case 0:
                                            tip("username","success");
                                            break;
                                        case 1:
                                            tip("username","error",sMsg);
                                            break;
                                        default:
                                            tip("username","error",'请输入由字母或数字组成的6-16位字符');
                                            break;
                                    }
                                })
                            }
                        }else{
                            var message = "不能以O或0开头";
                            tip("username","error",message);
                        }
                    }else{
                        var message = "不能输入连续4位相同的字符";
                        tip("username","error",message);
                    }
                }
            }
        });
        
        $("input[name='nickname']").blur(function(){
        	var nickname = $(this).val();
        	var uname = $("input[name='username']").val();
            
        	if(nickname == "")
        	{      		
        		var message = "用户昵称不能为空";
				tip("nickname","error",message);
        	}else{
        		if(nickname == uname){      			
        			var message = "不可与用户名相同";
					tip("nickname","error",message);
        		}else{
        			var re = /^[\u4e00-\u9fa5a-zA-Z0-9]{2,6}$/;
        			if(!re.test(nickname)){       				
        				var message = "请输入2-6个字符";
						tip("nickname","error",message);
        			}else{      				
						tip("nickname","success");
        			}
        		}      		
        	}
        });
        
        $("input[name='moblie']").blur(function(){
        	var moblie = $(this).val();
        	if(moblie == "")
        	{      		
        		var message = "手机号码不能为空";
				tip("moblie","error",message);
        	}else{
    			var re = /^1\d{10}$/;
    			if(!re.test(moblie)){
    				var message = "手机号码格式不正确,请重新输入";
					tip("moblie","error",message);
					$(this).val($(this).val().match(/1\d{1,10}/g));
    			}else{      				
					tip("moblie","success");
    			}     		
        	}
        });
         $("input[name='userpass']").blur(function(){
        	var upass = $(this).val();
        	var reu = /^[a-zA-Z0-9]{1,}$/;
        	if(upass != ""){
        		if(!reu.test(upass)){
	        		var message = "密码只能由字母和数字组成";
					tip("userpass","error",message);
					return false;
	        	}
        	}  
        	if(upass == "")
        	{       		
        		var message = "登录密码不能为空";
				tip("userpass","error",message);
        	}else{
        		var re = /(\w)*(\w)\2{2}(\w)*/g;
        		if(!re.test(upass)){
        			var re1 = /^(?![^a-zA-Z]+$)(?!\D+$).{6,16}$/;
        			if(!re1.test(upass)){       				
        				var message = "密码长度为6至16位，且必须同时包含字母和数字";
						tip("userpass","error",message);
        			}else{      			
						tip("userpass","success");
        			}
        		}else{        			
        			var message = "密码不能包含连续3位相同的字符";
					tip("userpass","error",message);
        		}
        	}			
        });
        
        $("input[name='code']").blur(function(){
        	var code = $(this).val();
            var tmp = $("input[name='tmp']").val();
            if (tmp == '' || code != tmp) {
                checkCode(code);
                $("input[name='tmp']").val(code);
            };
        });
        
        $(".toggle_pass").mousedown(function(){
        	$(this).siblings("input").prop("type","text");
        });
        $(".toggle_pass").mouseup(function(){
            $(this).siblings("input").prop("type","password");
        })

     }());

    });

function tip(sel,type,message){
    var $this = $("input[name="+sel+"]");
    if(type == "error"){
        $this.parents("li").find(".tip").removeClass("success-tip").addClass("error-tip").fadeIn();
        $this.parents("li").find(".tip p").text(message);
        autoVer();
    }else{
        $this.parents("li").find(".tip").removeClass("error-tip").addClass("success-tip").fadeIn();
        $this.parents("li").find(".tip p").text("");
    }
}

function autoVer(){
    $(".l_list_con .tip p").each(function(){
        var hh = $(this).height();
        var ph = 22 - hh/2;
        $(this).css({"margin-top":ph});
    });
}


function checkform(obj)
{
  if( !validateUserName(obj.username.value) )
  {
      $.alert("用户名 不符合规则，请重新输入");
	 obj.username.focus();
	 return false;
  }
  if( !validateUserPss(obj.userpass.value) )
  {
      $.alert("登录密码 不符合规则，请重新输入");
	obj.userpass.focus();
	return false;
  }
  if( !validateNickName(obj.nickname.value) )
  {
      $.alert("昵称 不符合规则，请重新输入");
	obj.nickname.focus();
	return false;
  }
  
  if( !validateRealName(obj.realname.value) )
  {
      $.alert("会员姓名 不符合规则，请重新输入");
	obj.realname.focus();
	return false;
  }
  if( !validateUserEmail(obj.useremail.value) )
  {
      $.alert("邮箱 不符合规则，请重新输入");
	obj.useremail.focus();
	return false;
  }
  if( !validateUserPhone(obj.moblie.value) )
  {
      $.alert("手机号码 不符合规则，请重新输入");
	obj.moblie.focus();
	return false;
  }
  if( obj.code.value == '' )
  {
      $.alert("请输入验证码！");
	obj.code.focus();
	return false;
  }
}

function validateRealName(str){
	if(str == '' || str == null){
		return true;
	}else{
		var re = /[^u4e00-u9fa5]/; 
		if(!re.test(str)){
			return false; 
		}else{
			return true; 
		}	
	}	
}


function validateUserEmail(str){
	if(str == '' || str == null){
		return true;
	}else{
		var a = /^[\w\-\.]+@[\w\-\.]+[\.\w+]+$/;
		if(a.exec(str)){
			return true;
		}else{
			return false;
		}
	}	
}


function validateUserPhone(str)
{
	if(str == '' || str == null){
		return true;
	}else{
		var reg=/^([0-9])+$/g ;
		if(str.length < 7 || str.length > 13){
			return false;
		}else{
		  return reg.exec(str);
		}
	}
}
</script>
<script type="text/javascript">


function refreshimg(){
    document.getElementById("validate").src="/?useValid=true&random="+Math.random();
    //tip("code","error",'验证码输入错误');
    $("input[name='tmp']").val('');
}

function checkCode(val) {
    var code = val;
    if(code == ""){
        var message = "验证码不能为空";
        tip("code","error",message);
    }else{
        var url= 'http://'+window.location.host + '/?controller=default&action=checkcode';
        var rq_post = {};
        rq_post['flag'] = 'checkCode';
        rq_post['validateCode'] = code;
        rq_post['Submit'] = 'json';
        $.post(url, rq_post, function(data){
            var json = jsonParse(data);
            var sMsg = json['sMsg']
            var sError = json['sError'];
            switch(sError){
                case 0:
                    tip("code","success");
                    break;
                case 1:
                    tip("code","error",sMsg);
                    break;
                default:
                    tip("code","error",'验证码输入错误');
                    break;
            }
        })
        
    }
}

</script>
<script type="text/javascript"> 
  var _gaq = _gaq || []; 
  _gaq.push(['_setAccount', 'UA-89609836-1']); 
  _gaq.push(['_trackPageview']); 
  (function() { 
    var ga = document.createElement('script'); 
    ga.type = 'text/javascript'; 
    ga.async = true; 
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; 
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); 
  })(); 
</script>
</head>
<body style=" min-width:980px; overflow-x:hidden;">
<div class="zc_top"><div class="warp980 clearfix">
	<h1 class="logo"></h1>
	<a href="javascript:void(0)" onclick="zxkf();" title="在线客服" class="zx_service">联系客服</a></div></div>
<div class="zc_cont zc_cont_1">
	<div class="zc_content">
		<div class="zc_title">欢迎您注册网站会员，如果您已拥有账户，则可在此<a href="/index.php">登录</a><span class="text_tit1"></span></div>
		<div class="zc_list" id="apDiv4">
			<ul id="reg_con">
			<?php if($args[0]){ ?>
             <form action="/index.php/user/reg" onkeydown="if(event.keyCode==13){return false;}"  method="post" onajax="registerBeforSubmit" enter="true" call="registerSubmit" target="ajax">
                 <input type="hidden" name="addtype" id="addtype" value="ks">
                 <input type="hidden" name="flag" value="insert">
				<li>
					<label class="zc_label">用户名：</label>
					<div class="zc_input"><i class="iczc-number"></i>
						<input type="text" name="username" id="username" class="forget_input" placeholder="请输入帐号" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength=15/>
						<p class="z1">由字母或数字组成的6-16个字符，不能连续4个相同字符，首字符不能为字母O或数字0</p>
                        <div class="tip"><em></em><p></p></div>
					</div>
				</li>
				<li>
					<label class="zc_label">用户昵称：</label>
					<div class="zc_input"><i class="iczc-username"></i>
						<input type="text" name="nickname" maxlength="6" class="forget_input">
						<p class="z2">由2至6个字符组成</p>
                        <div class="tip"><em></em><p></p></div>
					</div>
				</li>
				<li>
					<label class="zc_label">登录密码：</label>
					<div class="zc_input"><i class="iczc-password"></i>
						<input  type="password" name="userpass" maxlength="16" class="forget_input">
						<p class="z1">字母和数字组成6-16个字符（必须包含数字和字母）且连续三位字符不相同</p>
                        <div class="tip"><em></em><p></p></div>
					</div>
				</li>
				<li>
					<label class="zc_label">确认密码：</label>
					<div class="zc_input"><i class="iczc-password"></i>
						<input id="checkpwd" type="password" name="cpasswd" id="cpasswd" class="forget_input" placeholder="请确认密码" onKeyUp="value=value.replace(/[\W]/g,'')" maxLength=13>
						<p class="z1">请重复登录密码，要一致</p>
                        <div class="tip"><em></em><p></p></div>
					</div>
				</li>
				<li>
					<label class="zc_label">验证码：</label>
					<div class="zc_input"><i class="iczc-warning"></i>
						<input type="text" name="code" maxlength="4" class="forget_input" style="width:180px;">
						<img  onclick="this.src='/index.php/user/vcode/'+(new Date()).getTime()" title="点击刷新" style="cursor:pointer; border: 0px solid #999; vertical-align:middle;" src="/index.php/user/vcode/<?=$this->time?>" class="zc_code">
						<p class="z1"></p>
                        <div class="tip"><em></em><p></p></div>
					</div>
				</li>
				<li>
					<div class="zc_btn_box" style="text-align:center">
                    	<input type="hidden" name="id" value=""/>
		            	<input name="action" type="submit" class="login_btn submit zc_btn" value="立即注册">
                        <input type="hidden" name="tmp" value="" />
						<a href="/index.php">已有账号登录</a>
					</div>
				</li>
                </form>
				<?php }else{?>
				<div id="error">
					<h3>
						<font class="hint_red">无效的推广链接！</font>
					</h3>
					
				</div>
				<?php }?>
			</ul>
		</div>
	</div>
<div class="footer_lxfs">
</div>
</div>
<div class="login_footer">
<div class="warp980">
<div class="img"><img src="/images/nsc/login/nsc_login_footer-certificate.png?v=1.17.6.10" /></div>
<div class="clearfix"><p class="t-left">浏览器建议：首选为Google浏览器，其次为火狐和IE9或IE10浏览器<br />分辨率建议：使用1024×768以上的分辨率</p>
<p class="t-right">未满18周岁禁止购买<br />Copyright © SinCai 2010-2017  杏彩娱乐 版权所有</p></div>
</div>
</div>
<script type='text/javascript'>
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