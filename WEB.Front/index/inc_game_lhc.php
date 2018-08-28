
<div class="game-main" >
<div id="bet-game">
	<div class="game-btn">
        <?php
		if($_COOKIE['mode']){
			$mode=$_COOKIE['mode'];
		}else{
			$mode=1.00;
		}
		$this->getTypes();
		$sql="select id, groupName, enable from {$this->prename}played_group where enable=1 and type=? order by sort";
		$groups=$this->getObject($sql, 'id', $this->types[$this->type]['type']);

		if($this->groupId && !$groups[$this->groupId]) unset($this->groupId);
		
		if($groups) foreach($groups as $key=>$group){
			if(!$this->groupId) $this->groupId=$group['id'];
	?>
        <div class="ul-li<?=($this->groupId==$group['id'])?' current':''?>">
        	<a class="cai" href="/index.php/index/group/<?=$this->type .'/'.$group['id']?>"><span class="content"><?=$group['groupName']?></span></a>
		</div>
	<?php } ?>
    <div class="clear"></div>
	</div>
	<div class="game-cont">
		<?php $this->display('index/inc_game_played.php'); ?>
	</div>
</div>

</div>
	<!-----------投注记录----------------->		
		<?php if($this->settings['tzjl']==1){?>
	</div>




<img  width="100%" height="100%">
<div id="znz-game" style="display:none;"></div>
</div>
<div class="warp lotteryHistory">
        <div class="lotteryHistoryBody">
     
        </div>
     
           		
				   <div class="line">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					    <th>单号</th>
						<th>投注时间</th>
						<th>彩种</th>
						<th>玩法</th>
						<th>期号</th>
						<th>投注号码(点击查看)</th>
						<th>倍数</th>
						<th>金额(元)</th>
						<th>奖金(元)</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="order-history"><?php $this->display('index/inc_game_order_history.php'); ?></tbody>
				

			</table>
	

<div class="getMore"><a class="sqlist" href="/index.php/record/search" title="查看更多投注记录" target="_blank">查看更多</a></div></div>
	<?}?>
	

	<div class="clear"></div>