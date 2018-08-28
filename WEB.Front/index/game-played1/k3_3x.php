<input type="hidden" name="playedGroup" value="<?=$this->groupId?>" />
<input type="hidden" name="playedId" value="<?=$this->played?>" />
<input type="hidden" name="type" value="<?=$this->type?>" />

<div>
<div class="pp pp11" action="tz11x5Select" length="3" >
	<div class="title">号码</div>
	<input type="button" value="1" class="code" />
	<input type="button" value="2" class="code" />
    <input type="button" value="3" class="code" />
    <input type="button" value="4" class="code" />
    <input type="button" value="5" class="code" />
    <input type="button" value="6" class="code" />
</div>
</div>

<?php
	
	$maxPl=$this->getPl($this->type, $this->played);
?>
<script type="text/javascript">
$(function(){
	gameSetPl(<?=json_encode($maxPl)?>);
})
</script>