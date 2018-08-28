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
		echo"<script>alert('转账金额不能大于账户余额，请重新输入。');history.go(-1);</script>";  
        exit;
}

 if($zztype == '11' || $zztype == '12' || $zztype == '13' ){
		$res=new Biapi();
		$result=$res->zzmoney($game,$user,'IN',$yy);
		if($result){//充值成功
			$res_money=$conver-$yy;
			$chongzhi="update z4r5jk12_members set coin=".$res_money." where username='".$user."'";
            mysql_query($chongzhi,$conn); 
			echo "<script>alert('转入成功".$yy."元');history.go(-1);</script>";
			exit;
		}else{
			//echo '转换失败111'; 
			echo"<script>alert('转换失败');history.go(-1);</script>";  
			exit;
		}			
		}else if($zztype == '21' || $zztype == '22' || $zztype == '23' ){
			$res=new Biapi();
			$result=$res->zzmoney($game,$user,'OUT',$yy);
		    if($result){//提现成功
			$res_money=$conver+$yy;
			$tixian=mysql_query("update z4r5jk12_members set coin=".$res_money." where username='".$user."'");
            $conver = mysql_result($tixian,0);
			echo "<script>alert('转出成功".$yy."元');history.go(-1);</script>";
			exit;
	}else{
		echo"<script>alert('转换失败2');history.go(-1);</script>";  
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>额度转换</title>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,user-scalable=no,maximum-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="/static/add/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="images/member.css?v=123"/>
<script type="text/javascript" src="images/member.js"></script>
<script type="text/javascript" src="/static/add/js/TweenMax.min.js"></script>
<script type="text/javascript" src="/static/add/js/Stats.min.js"></script>
<script src="/static/add/js/bootstrap.min.js"></script>
<style>
#edsvg{
	    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
}
svg {
  width: 100%;
  height: 100%;
}
svg g {
  mix-blend-mode: lighten;
}
svg polygon {
  stroke: none;
  fill: white;
}
</style>
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
<div id="edsvg">
	<svg id="demo" viewBox="0 0 1600 600" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="grad1" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
      <stop id="stop1a" offset="0%" stop-color="#e62325"></stop>
      <stop id="stop1b" offset="100%" stop-color="#5a3ec8"></stop>
    </linearGradient>
    <linearGradient id="grad2" x1="0" y1="0" x2="1" y2="0" color-interpolation="sRGB">
      <stop id="stop2a" offset="0%" stop-color="#5a3ec8"></stop>
      <stop id="stop2b" offset="100%" stop-color="#dc267f"></stop>
    </linearGradient>
  </defs>
  <rect id="rect1" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad1)" style="opacity: 0;"></rect>
  <rect id="rect2" x="0" y="0" width="1600" height="600" stroke="none" fill="url(#grad2)" style="opacity: 1;"></rect>
  </svg>
</div>

<div class="zr_table">
<div>
	<div class="tr_tit" style="color:#f00;font-size:16px;">账户转账</div>
		<form id="form1" name="form1" action="?save=ok" method="post">
			  <div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 tr_r">用户账号：</div>
				<div class="col-xs-8 col-sm-8 col-md-8"><?=$user?></div>
			</div>
			 <div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 tr_r">钱包额度：</div>
				<div class="col-xs-8 col-sm-8 col-md-8"><?=sprintf("%.2f",$conver)?></div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 tr_r">真人额度：</div>
				<div class="col-xs-8 col-sm-8 col-md-8" style="color:#f00;">[AG] <?=$ag_balance?></div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 tr_r">转账选择：</div>
				<div class="col-xs-8 col-sm-8 col-md-8">
					<select name="zz_type" id="zz_type">
						<option value ="12">转入AG账户</option>
						<option value ="22">AG账户转出</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 tr_r">转账金额：</div>
				<div class="col-xs-8 col-sm-8 col-md-8">
					<input name="zz_money" type="text" class="input_150" id="zz_money" onkeyup="clearNoNum(this);" maxlength="10" size="15"/>
					<input name="user" type="hidden" id="user" value="<?=$user?>">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4"></div>
				<div class="col-xs-8 col-sm-8 col-md-8">
					<input name="SubTran" type="button"  id="SubTran" onclick="SubInfo();" value="请稍后..." disabled="disabled" />
				</div>
			</div>
		</form>
</div>
</div>
<!--<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" style="border:1px #FFF solid;" class="zr_table">
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
									   <!--[BBIN] <span  style="margin-right:10px"><?=$bb_balance?></span-->	
                                 									   
									<!--</td> 
										
								</tr>
								<tr>
								<td align="right" bgcolor="#FAFAFA">转账选择：</td>
								<td align="left">
									<select name="zz_type" id="zz_type">
										<option value ="12">主账户-&gt;AG娱乐场</option>

								
										<option value ="22">AG娱乐场-&gt;主账户</option>

									
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
</table>-->
<script>
//////////////////////////////
// Demo Functions
//////////////////////////////

function init(showStats) {
  // stats
  if (showStats) {
    var stats = new Stats();
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.left = '0';
    stats.domElement.style.top = '0';
    document.body.appendChild(stats.domElement);
    requestAnimationFrame(function updateStats(){
      stats.update();
      requestAnimationFrame(updateStats);
    });
  }

  // init
  var svg = document.getElementById('demo');
  tesselation.setup(svg);
  gradients.setup();

  var lastTransitionAt, transitionDelay = 5500, transitionDuration = 3000;

  function playNextTransition() {
    tesselation.next(transitionDuration);
    gradients.next(transitionDuration);
  };

  function tick(time) {
    if (!lastTransitionAt || time - lastTransitionAt > transitionDelay) {
      lastTransitionAt = time;
      playNextTransition();
    }
    window.requestAnimationFrame(tick);
  }
  window.requestAnimationFrame(tick);
}

//////////////////////////////
// Delaunay Triangulation
//////////////////////////////

var calcDelaunayTriangulation = (function() {
  var EPSILON = 1.0 / 1048576.0;
  function getSuperT(vertices) {
    var xMin = Number.POSITIVE_INFINITY, yMin = Number.POSITIVE_INFINITY,
        xMax = Number.NEGATIVE_INFINITY, yMax = Number.NEGATIVE_INFINITY,
        i, xDiff, yDiff, maxDiff, xCenter, yCenter;
    for(i = vertices.length; i--; ) {
      if(vertices[i][0] < xMin) xMin = vertices[i][0];
      if(vertices[i][0] > xMax) xMax = vertices[i][0];
      if(vertices[i][1] < yMin) yMin = vertices[i][1];
      if(vertices[i][1] > yMax) yMax = vertices[i][1];
    }
    xDiff = xMax - xMin;
    yDiff = yMax - yMin;
    maxDiff = Math.max(xDiff, yDiff);
    xCenter = xMin + xDiff * 0.5;
    yCenter = yMin + yDiff * 0.5;
    return [
      [xCenter - 20 * maxDiff, yCenter - maxDiff],
      [xCenter, yCenter + 20 * maxDiff],
      [xCenter + 20 * maxDiff, yCenter - maxDiff]
    ];
  }
  function circumcircle(vertices, i, j, k) {
    var xI = vertices[i][0], yI = vertices[i][1],
        xJ = vertices[j][0], yJ = vertices[j][1],
        xK = vertices[k][0], yK = vertices[k][1],
        yDiffIJ = Math.abs(yI - yJ), yDiffJK = Math.abs(yJ - yK),
        xCenter, yCenter, m1, m2, xMidIJ, xMidJK, yMidIJ, yMidJK, xDiff, yDiff;
    // bail condition
    if(yDiffIJ < EPSILON && yDiffJK < EPSILON)
      throw new Error("Can't get circumcircle since all 3 points are y-aligned");
    // calc circumcircle center x/y, radius
    m1  = -((xJ - xI) / (yJ - yI));
    m2  = -((xK - xJ) / (yK - yJ));
    xMidIJ = (xI + xJ) / 2.0;
    xMidJK = (xJ + xK) / 2.0;
    yMidIJ = (yI + yJ) / 2.0;
    yMidJK = (yJ + yK) / 2.0;
    xCenter = (yDiffIJ < EPSILON) ? xMidIJ :
      (yDiffJK < EPSILON) ? xMidJK :
      (m1 * xMidIJ - m2 * xMidJK + yMidJK - yMidIJ) / (m1 - m2);
    yCenter  = (yDiffIJ > yDiffJK) ?
      m1 * (xCenter - xMidIJ) + yMidIJ :
      m2 * (xCenter - xMidJK) + yMidJK;
    xDiff = xJ - xCenter;
    yDiff = yJ - yCenter;
    // return
    return {i: i, j: j, k: k, x: xCenter, y: yCenter, r: xDiff * xDiff + yDiff * yDiff};
  }
  function dedupeEdges(edges) {
    var i, j, a, b, m, n;
    for(j = edges.length; j; ) {
      b = edges[--j]; a = edges[--j];
      for(i = j; i; ) {
        n = edges[--i]; m = edges[--i];
        if((a === m && b === n) || (a === n && b === m)) {
          edges.splice(j, 2); edges.splice(i, 2);
          break;
        }
      }
    }
  }
  return function(vertices) {
    var n = vertices.length,
        i, j, indices, st, candidates, locked, edges, dx, dy, a, b, c;
    // bail if too few / too many verts
    if(n < 3 || n > 2000)
      return [];
    // copy verts and sort indices by x-position
    vertices = vertices.slice(0);
    indices = new Array(n);
    for(i = n; i--; )
      indices[i] = i;
    indices.sort(function(i, j) {
      return vertices[j][0] - vertices[i][0];
    });
    // supertriangle
    st = getSuperT(vertices);
    vertices.push(st[0], st[1], st[2]);
    // init candidates/locked tris list
    candidates = [circumcircle(vertices, n + 0, n + 1, n + 2)];
    locked = [];
    edges = [];
    // scan left to right
    for(i = indices.length; i--; edges.length = 0) {
      c = indices[i];
      // check candidates tris against point
      for(j = candidates.length; j--; ) {
        // lock tri if point to right of circumcirc
        dx = vertices[c][0] - candidates[j].x;
        if(dx > 0.0 && dx * dx > candidates[j].r) {
          locked.push(candidates[j]);
          candidates.splice(j, 1);
          continue;
        }
        // point outside circumcirc = leave candidates
        dy = vertices[c][1] - candidates[j].y;
        if(dx * dx + dy * dy - candidates[j].r > EPSILON)
          continue;
        // point inside circumcirc = break apart, save edges
        edges.push(
          candidates[j].i, candidates[j].j,
          candidates[j].j, candidates[j].k,
          candidates[j].k, candidates[j].i
        );
        candidates.splice(j, 1);
      }
      // new candidates from broken edges
      dedupeEdges(edges);
      for(j = edges.length; j; ) {
        b = edges[--j];
        a = edges[--j];
        candidates.push(circumcircle(vertices, a, b, c));
      }
    }
    // close candidates tris, remove tris touching supertri verts
    for(i = candidates.length; i--; )
      locked.push(candidates[i]);
    candidates.length = 0;
    for(i = locked.length; i--; )
      if(locked[i].i < n && locked[i].j < n && locked[i].k < n)
        candidates.push(locked[i].i, locked[i].j, locked[i].k);
    // done
    return candidates;
  };
})();

var tesselation = (function() {
  var svg, svgW, svgH, prevGroup;

  function createRandomTesselation() {
    var wW = window.innerWidth;
    var wH = window.innerHeight;

    var gridSpacing = 250, scatterAmount = 0.75;
    var gridSize, i, x, y;

    if (wW / wH > svgW / svgH) { // window wider than svg = use width for gridSize
      gridSize = gridSpacing * svgW / wW;
    } else { // window taller than svg = use height for gridSize
      gridSize = gridSpacing * svgH / wH;
    }

    var vertices = [];
    var xOffset = (svgW % gridSize) / 2, yOffset = (svgH % gridSize) / 2;
    for (x = Math.floor(svgW/gridSize) + 1; x >= -1; x--) {
      for (y = Math.floor(svgH/gridSize) + 1; y >= -1; y--) {
        vertices.push(
          [
            xOffset + gridSize * (x + scatterAmount * (Math.random() - 0.5)),
            yOffset + gridSize * (y + scatterAmount * (Math.random() - 0.5))
          ]
        );
      }
    }

    var triangles = calcDelaunayTriangulation(vertices);

    var group = document.createElementNS('http://www.w3.org/2000/svg','g');
    var polygon;
    for(i = triangles.length; i; ) {
      polygon = document.createElementNS('http://www.w3.org/2000/svg','polygon');
      polygon.setAttribute('points',
        vertices[triangles[--i]][0] + ',' + vertices[triangles[i]][1] + ' ' +
        vertices[triangles[--i]][0] + ',' + vertices[triangles[i]][1] + ' ' +
        vertices[triangles[--i]][0] + ',' + vertices[triangles[i]][1]
      );
      group.appendChild(polygon);
    }

    return group;
  }

  return {
    setup: function(svgElement) {
      svg = svgElement;
      var vb = svg.getAttribute('viewBox').split(/\D/g);
      svgW = vb[2];
      svgH = vb[3];
    },
    next: function(t) {
      var toRemove, i, n;
      t /= 1000;

      if (prevGroup && prevGroup.children && prevGroup.children.length) {
        toRemove = prevGroup;
        n = toRemove.children.length;
        for (i = n; i--; ) {
          TweenMax.to(toRemove.children[i], t*0.4, {opacity: 0, delay: t*(0.3*i/n)});
        }
        TweenMax.delayedCall(t * (0.7 + 0.05), function(group) { svg.removeChild(group); }, [toRemove], this);
      }
      var g = createRandomTesselation();
      n = g.children.length;
      for (i = n; i--; ) {
        TweenMax.fromTo(g.children[i], t*0.4, {opacity: 0}, {opacity: 0.3 + 0.25 * Math.random(), delay: t*(0.3*i/n + 0.3), ease: Back.easeOut});
      }
      svg.appendChild(g);
      prevGroup = g;
    }
  }
})();

//////////////////////////////
// Gradients
//////////////////////////////

var gradients = (function() {
  var grad1, grad2, showingGrad1;

  // using colors from IBM Design Colors this time
  var colors = [ // 14 colors - use 3-5 span
    '#3c6df0', // ultramarine50
    '#12a3b4', // aqua40
    '#00a78f', // teal40
    '#00aa5e', // green40
    '#81b532', // lime30
    '#e3bc13', // yellow20
    '#ffb000', // gold20
    '#fe8500', // orange30
    '#fe6100', // peach40
    '#e62325', // red50
    '#dc267f', // magenta50
    '#c22dd5', // purple50
    '#9753e1', // violet50
    '#5a3ec8'  // indigo60
  ];

  function assignRandomColors(gradObj) {
    var rA = Math.floor(colors.length * Math.random());
    var rB = Math.floor(Math.random() * 3) + 3; // [3 - 5]
    rB = (rA + (rB * (Math.random() < 0.5 ? -1 : 1)) + colors.length) % colors.length;
    gradObj.stopA.setAttribute('stop-color', colors[rA]);
    gradObj.stopB.setAttribute('stop-color', colors[rB]);
  }

  return {
    setup: function() {
      showingGrad1 = false;
      grad1 = {
        stopA: document.getElementById('stop1a'),
        stopB: document.getElementById('stop1b'),
        rect:  document.getElementById('rect1')
      };
      grad2 = {
        stopA: document.getElementById('stop2a'),
        stopB: document.getElementById('stop2b'),
        rect:  document.getElementById('rect2')
      };
      grad1.rect.style.opacity = 0;
      grad2.rect.style.opacity = 0;
    },
    next: function(t) {
      t /= 1000;

      var show, hide;
      if (showingGrad1) {
        hide = grad1;
        show = grad2;
      } else {
        hide = grad2;
        show = grad1;
      }
      showingGrad1 = !showingGrad1;

      TweenMax.to(hide.rect, 0.55*t, {opacity: 0, delay: 0.2*t, ease: Sine.easeOut});
      assignRandomColors(show);
      TweenMax.to(show.rect, 0.65*t, {opacity: 1, ease: Sine.easeIn});
    }
  };
})();

//////////////////////////////
// Start
//////////////////////////////

init();
</script>

</body>
</html>