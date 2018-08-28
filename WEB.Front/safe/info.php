<?php $this->display('inc_daohang.php'); ?>


<div id="nsc_subContent" style="border:0">
<script type="text/javascript">

	$(function() {
		$( ".menus-li li").click(function(){
            $( ".menus-li li").removeClass("on");
            $(this).addClass("on");
            $("#tabs-1,#tabs-2").hide();
            $("#tabs-"+($(this).index()+1)).show();
        });
	})
</script>

<div id="siderbar">
<ul class="list clearfix">
<li class="current"><a href="/index.php/safe/info" >绑定卡号</a></li>
<li ><a href="/index.php/safe/passwd" >密码修改</a></li>
<li ><a href="/index.php/record/search" >投注记录</a></li>
<li ><a href="/index.php/report/coin" >帐变记录</a></li>
<li ><a href="/index.php/report/count" >盈亏报表</a></li>
<li ><a href="/index.php/cash/rechargeLog" >充值记录</a></li>
<li ><a href="/index.php/cash/toCashLog" >提现记录</a></li>
<li ><a href="/index.php/user/nickname" >更改称昵</a></li>
<li ><a href="/index.php/box/receive" >消息管理</a></li>
</ul>
</div>
<link rel="stylesheet" href="/css/nsc/reset.css?v=1.16.11.5" />
<link rel="stylesheet" href="/css/nsc/list.css?v=1.16.11.5" />
<link rel="stylesheet" href="/css/nsc/activity.css?v=1.16.11.5" />
<script type="text/javascript" src="/js/nsc/jquery-1.7.min.js?v=1.16.11.5"></script>
<script type="text/javascript" src="/js/nsc/main.js?v=1.16.11.5"></script>
<script type="text/javascript" src="/js/nsc/dialogUI/jquery.dialogUI.js?v=1.16.11.5"></script>
<link href="/css/nsc/plugin/dialogUI/dialogUI.css?v=1.16.11.5" media="all" type="text/css" rel="stylesheet" />
</head>
<body>

<div id="subContent_bet_re">
<!--消息框代码开始-->
<script src="/js/jqueryui/ui/jquery.ui.core.js?v=1.16.11.5"></script>
<script src="/js/jqueryui/ui/jquery.ui.widget.js?v=1.16.11.5"></script>
<script src="/js/jqueryui/ui/jquery.ui.tabs.js?v=1.16.11.5"></script>
<script language="javascript" type="text/javascript" src="/js/common/jquery.md5.js?v=1.16.11.5"></script>
<script type="text/javascript" src="/js/keypad/jquery.keypad.js?v=1.16.11.5"></script>
<link rel="stylesheet" type="text/css" media="all" href="/js/keypad/keypad.css?v=1.16.11.5"  />
<!--消息框代码结束-->

<form action="/index.php/safe/setCBAccount" method="post" target="ajax" onajax="safeBeforSetCBA" call="safeSetCBA">
<?php if($this->user['coinPassword']){ ?>
        
          <table width="100%" border="0" cellspacing="1" cellpadding="0" class="grayTable">
              <tr>
				<th>银行类型</th>
                
                <th>提现帐号</th>
				<th>真实姓名</th>
                <th>真实地址</th>
                <th>资金密码</th>
              </tr>
			                <tr>
                
        <td>
				<?php
            $myBank=$this->getRow("select * from {$this->prename}member_bank where uid=?", $this->user['uid']);
				$banks=$this->getRows("select * from {$this->prename}bank_list where isDelete=0 and id !=20 and id !=15 and id !=2 and id !=12  order by sort");
	
				$flag=($myBank['editEnable']!=1)&&($myBank);
			?>
			<select name="bankId" class="text5" <?=$this->iff($flag, 'disabled')?>>
			<?php foreach($banks as $bank){ ?>
			<option value="<?=$bank['id']?>" <?=$this->iff($myBank['bankId']==$bank['id'], 'selected')?>><?=$bank['name']?></option>
			<?php } ?>
			</select>
		</td>
		<td>
			<input type="text" name="account" class="text4" value="<?=preg_replace('/^(\w{4}).*(\w{4})$/', '\1***********\2',htmlspecialchars($myBank['account']))?>" <?=$this->iff($flag, 'readonly')?> style="width:125px;"/>
		</td>
		<td>
			<input type="text" name="username" class="text4"  value="<?=$this->iff($myBank['username'],mb_substr(htmlspecialchars($myBank['username']),0,1,'utf-8').'**')?>"  <?=$this->iff($flag, 'readonly')?>  />
		</td>
         <td>
		 <input type="text" id="countname"  style="<?php if(!$flag) echo'display:none;';?> "  name="countname" class="text4" value="<?=preg_replace('/^(\w{4}).*(\w{4})$/','\1***\2',htmlspecialchars($myBank['countname']))?>" <?=$this->iff($flag, 'readonly')?> style="width:222px;"/>
		<select id="add_sheng" name="add_sheng"  style=" <?php if($flag) echo'display:none;';?> ">
 		  <option value ="shandong">山东</option>
 		  <option value ="henan">河南省</option>
		  <option value ="anhui">安徽省</option>
		  <option value ="beijing">北京</option>
		  <option value ="fujian">福建省</option>
		  <option value ="gansu">甘肃省</option>
		  <option value ="guangdong">广东省</option>
		  <option value ="guangxi">广西自区</option>
		  <option value ="guizhou">贵州省</option>
		  <option value ="hainan">海南省</option>
		  <option value ="hebei">河北省</option>
		  <option value ="heilongjiang">黑龙江省</option>
		  <option value ="hubei">湖北省</option>
		  <option value ="hunan">湖南省</option>
		  <option value ="jilin">吉林省</option>
		  <option value ="jiangsu">江苏省</option>
		  <option value ="jiangxi">江西省</option>
		  <option value ="niaoning">辽宁省</option>
		  <option value ="neimenggu">内蒙古自区</option>
		  <option value ="ningxia">宁夏自区</option>
		  <option value ="qinghai">青海省</option>
		  <option value ="shandong">山东省</option>
		  <option value ="shanxi">山西省</option>
		  <option value ="shanghai">上海市</option>
		  <option value ="sichuan">四川省</option>
		  <option value ="tianjin">天津市</option>
		  <option value ="xizang">西藏自区</option>
		  <option value ="xinjiang">新疆自区</option>
		  <option value ="yunnan">云南省</option>
		  <option value ="zhejiang">浙江省</option>
		  <option value ="chongqing">重庆市</option>
		</select>

<select id="add_shiqu" name="add_shiqu"  style="<?php if($flag) echo'display:none;';?> ">
    <option value ="">请选择</option>
</select>



<script>
    $(function(){
        //初始化数据
        var url = '/getadd.php'; //后台地址
        $("#add_sheng").change(function(){  //监听下拉列表的change事件
            var address = $(this).val();  //获取下拉列表选中的值
            //发送一个post请求
            $.ajax({
                type:'get',
                url:url,
                data:{key:address},
                dataType:'json',
                success:function(data){  //请求成功回调函数
                    var address = data;
					    console.log(address);
                        var option = '';
						 for(var i=0;i<address.length;i++){  //循环获取返回值，并组装成html代码
                            option +='<option value="'+address[i]['code']+'">'+address[i]['cn']+'</option>';
                        }

                    $("#add_shiqu").html(option);  //js刷新第二个下拉框的值
					 $("#countname").val($("#add_sheng option:selected").text()+"省"+$("#add_shiqu option:selected").text()+"市");
                },
            });
        });
		
		
		
		
		
		 $("#add_shiqu").change(function(){  //监听下拉列表的change事件
		     //alert($("#add_sheng option:selected").text()+$("#add_shiqu option:selected").text());
             $("#countname").val($("#add_sheng option:selected").text()+"省"+$("#add_shiqu option:selected").text()+"市");
        });
		
		
    });
    </script>


		</td>
        <td>
		<input type="password" name="coinPassword" value="<?=preg_replace('/^(\w{4}).*(\w{4})$/','\1***\2',htmlspecialchars($myBank['account']))?>"  class="text4" <?=$this->iff($flag, 'readonly')?> />
		
		
		</td>
		</tr>
		</table>
        <div class="list_btn_box">
         <input id="setbank"  type="submit" <?=$this->iff($flag, 'disabled')?> value="设置银行" class="formZjbd" />
				<!--input type="reset" id="reset" value="重置" onClick="this.form.reset()" class="formZjbd" /-->
 			</div>
        </form>
		
	<?php }else{?>	
		
	<div id="subContent_bet_re">
		<div id="error">
		<h3>
			<font class="hint_red">您还未设定提款密码，为了您的账户安全，请先设定好您的提款密码</font>
		</h3>
		<div class="yhlb_back"><a href="/index.php/safe/passwd">设置资金密码</a></div>
						</div>

﻿</div>	
		
<?php }?>
	


</div>
</div></div></div></div></div>
<?php $this->display('inc_che.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){
				});
	jQuery("input.password").keypad({
	layout: [
			$.keypad.SPACE + $.keypad.SPACE + $.keypad.SPACE + '1234567890',
			'cdefghijklmab', 
							"stuvwxyznopqr"/*+ $.keypad.CLEAR*/,
							$.keypad.SPACE + $.keypad.SPACE + $.keypad.SHIFT + $.keypad.CLEAR + $.keypad.BACK + $.keypad.CLOSE
			],
	 // 软键盘按键布局 
	buttonImage:'/js/keypad/kb.png',	// 弹出(关闭)软键盘按钮图片地址
	buttonImageOnly: true,	// True 表示已图片形式显示, false 表示已按钮形式显示
	buttonStatus: '打开/关闭软键盘', // 打开/关闭软键盘按钮说明文字
	showOn: 'button', // 'focus'表示已输入框焦点弹出, 
		// 'button'通过按钮点击弹出,或者 'both' 表示两者都可以弹出 
		
	keypadOnly: false, // True 表示只接受软件盘输入, false 表示可以通过键盘和软键盘输入
		
	randomiseNumeric: true, // True 表示对所以数字位置进行随机排列, false 不随机排列
	randomiseAlphabetic: true, // True 表示对字母进行随机排列, false 不随机排列 
	
			clearText: '清空', // Display text for clear link 
			clearStatus: '', // Status text for clear l
			
	shiftText: '大小写', // SHIFT 按键功能的键的显示文字 
	shiftStatus: '转换字母大小写', // SHIFT按键功能的TITLE说明文字 
	
	closeText: '关闭', // 关闭按键功能的显示文字 
	closeStatus: '关闭软键盘', // 关闭按键功能的TITLE说明文字 
	
	backText: '退格', // 退格功能键的显示文字 
	backStatus: '退格', // 退格功能键的说明文字
		   
	onClose: null	// 点击软键盘关闭是调用的函数
	});
</script>


 </body>
 </html>
