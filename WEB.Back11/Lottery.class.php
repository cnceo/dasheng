<?php

@session_start();
class lottery extends WebLoginBase
{
	public $pageSize = 10;
	private $vcodeSessionName = 'z4r5jk12_vcode_session_name';
	public final function combine_buy()
	{
		$this->getTypes();
		$this->getPlayeds();
		$this->display('lottery/combine_list.php');
	}
	public final function hemai()
	{
		$this->getTypes();
		$this->getPlayeds();
		$this->action = 'combine_buy';
		$this->display('lottery/he-mai.php');
	}
	public final function comInfo($_var_0)
	{
		$this->getTypes();
		$this->getPlayeds();
		$this->display('lottery/com-info.php', 0, intval($_var_0));
	}
	public final function search()
	{
		$this->getTypes();
		$this->getPlayeds();
		$this->action = 'searchGameRecord';
		$this->display('lottery/search.php');
	}
	public final function searchGameRecord()
	{
		$this->getTypes();
		$this->getPlayeds();
		$this->display('lottery/search-list.php');
	}
		//充值提现详细信息弹出
	public final function rml($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('lottery/hemai-info.php', 0 , $id);
	}
	public final function cml($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('lottery/combine-info.php', 0 , $id);
	}
	
}
