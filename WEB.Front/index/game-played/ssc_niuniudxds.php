<input type="hidden" name="playedGroup" value="<?=$this->groupId?>" />
<input type="hidden" name="playedId" value="<?=$this->played?>" />
<input type="hidden" name="type" value="<?=$this->type?>" />
<?php foreach(array('有牛') as $var){ ?>
<div class="pp" action="tz5xDwei" length="1" random="sscRandom">
	<div class="title"><?=$var?></div>
	&nbsp;
	<input type="button" value="大" class="code reset2" />
	<input type="button" value="小" class="code reset2" />
	<input type="button" value="单" class="code reset2" />
	<input type="button" value="双" class="code reset2" />

	&nbsp;&nbsp;

</div>
<?php
	}
	
	$maxPl=$this->getPl($this->type, $this->played);
?>
<script type="text/javascript">
$(function(){
	gameSetPl(<?=json_encode($maxPl)?>);
})
</script>

