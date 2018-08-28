<?php

@session_start();
class Score extends WebLoginBase
{
	private $vcodeSessionName = 'z4r5jk12_vcode_session_name';
	public $scoretype = 'current';
	public $limittype = 'all';
	public $pageSize = 3;
	public $payout = 0.85;
	public final function zadan()
	{
		$this->display('score/xyzd.php');
	}
	public final function qiandao()
	{
		$this->display('score/qiandao.php');
	}
	public final function chongzhi()
	{
		$this->display('score/chongzhi.php');
	}
	public final function yongjin()
	{
		$_var_0 = 'select * from z4r5jk12_yongjin where id>1 and type=1 order by endtime';
		$this->dataa = $this->getRows($_var_0);
		$_var_0 = 'select * from z4r5jk12_yongjin where id=1';
		$this->dataaa = $this->getRows($_var_0);
		$this->display('score/yongjin.php');
	}
	public final function getyj()
	{
		$_var_1 = $this->user['uid'];
		$_var_2 = "select todayget from z4r5jk12_members where uid={$_var_1}";
		$_var_3 = $this->getRows($_var_2);
		if ($_var_3[0]['todayget'] == 1) {
			echo 'o';
			die;
		}
		$_var_2 = 'select * from z4r5jk12_yongjin where id=1';
		$_var_4 = $this->getRows($_var_2);
		if ($_var_4[0]['type'] == 0) {
			echo 'g';
			die;
		} else {
			$_var_5 = (int) date('H');
			if ((int) $_var_4[0]['startime'] <= $_var_5) {
				if ($_var_5 <= (int) $_var_4[0]['endtime']) {
					if (!$this->noeasy()) {
						echo 'n';
					} else {
						$_var_6 = $this->noeasy();
						$_var_2 = "update z4r5jk12_members set coin=coin+{$_var_6},todayget=1 where uid={$_var_1}";
						$this->exec($_var_2);
						$_var_2 = "select coin from z4r5jk12_members where uid={$_var_1}";
						$_var_7 = $this->getRows($_var_2);
						$_var_8 = $_var_7[0]['coin'];
						$_var_9 = time();
						$_var_2 = "insert into z4r5jk12_coin_log (actionTime,uid,liqType,coin,userCoin)values({$_var_9},{$_var_1},'56',{$_var_6},{$_var_8})";
						$this->exec($_var_2);
						$_var_10 = $this->user['username'];
						$_var_2 = "insert into z4r5jk12_yj_log (uid,username,amount,actionTime)values({$_var_1},'{$_var_10}',{$_var_6},'{$_var_9}')";
						$this->exec($_var_2);
						echo 'y';
					}
					die;
				} else {
					echo 'w';
				}
			} else {
				echo 'w';
			}
		}
		die;
	}
	public final function noeasy()
	{
		$_var_11 = $this->user['uid'];
		$_var_12 = "select uid,parents from z4r5jk12_members where parents like '%,{$_var_11},%' or parents like '{$_var_11},%'";
		$_var_13 = $this->getRows($_var_12);
		$_var_14 = 0;
		$_var_15 = '(';
		for ($_var_16 = 0; $_var_16 < count($_var_13); $_var_16++) {
			$_var_17 = explode(',', $_var_13[$_var_16]['parents']);
			if (count($_var_17) > 5) {
				for ($_var_18 = 0; $_var_18 < 5; $_var_18++) {
					if ($_var_17[count($_var_17) - $_var_18 - 1] == $_var_11) {
						$_var_19[$_var_14]['uid'] = $_var_13[$_var_16]['uid'];
						$_var_19[$_var_14]['lv'] = $_var_18;
						$_var_14++;
						$_var_15 .= $_var_13[$_var_16]['uid'] . ',';
						break;
					}
				}
			} else {
				for ($_var_18 = 0; $_var_18 < count($_var_17); $_var_18++) {
					if ($_var_17[count($_var_17) - $_var_18 - 1] == $_var_11) {
						$_var_19[$_var_14]['uid'] = $_var_13[$_var_16]['uid'];
						$_var_19[$_var_14]['lv'] = $_var_18;
						$_var_15 .= $_var_13[$_var_16]['uid'] . ',';
						$_var_14++;
						break;
					}
				}
			}
		}
		$_var_15 = substr($_var_15, 0, strlen($_var_15) - 1);
		$_var_15 .= ')';
		$_var_20 = date('Y-m-d H') . ':00:00';
		$_var_12 = "select uid,sum(mode*beiShu*actionNum) allmoney from z4r5jk12_bets where uid in {$_var_15} and (actionTime between UNIX_TIMESTAMP('{$_var_20}')-24*3600 and UNIX_TIMESTAMP('{$_var_20}')) group by uid";
		$_var_21 = $this->getRows($_var_12);
		for ($_var_16 = 0; $_var_16 < count($_var_21); $_var_16++) {
			for ($_var_18 = 0; $_var_18 < count($_var_19); $_var_18++) {
				if ($_var_21[$_var_16]['uid'] == $_var_19[$_var_18]['uid']) {
					$_var_21[$_var_16]['lv'] = $_var_19[$_var_18]['lv'];
				}
			}
		}
		$_var_12 = 'select * from z4r5jk12_yongjin where id>1 order by endtime desc';
		$_var_22 = $this->getRows($_var_12);
		for ($_var_16 = 0; $_var_16 < count($_var_22); $_var_16++) {
			if ($_var_22[$_var_16]['type'] == 1) {
				$_var_23[] = $_var_22[$_var_16];
			}
		}
		for ($_var_16 = 0; $_var_16 < count($_var_21); $_var_16++) {
			for ($_var_18 = 0; $_var_18 < count($_var_23); $_var_18++) {
				if ($_var_21[$_var_16]['allmoney'] >= $_var_23[$_var_18]['endtime']) {
					if ($_var_21[$_var_16]['lv'] == 1) {
						$_var_21[$_var_16]['getmoney'] = $_var_23[$_var_18]['lvone'];
					} else {
						if ($_var_21[$_var_16]['lv'] == 2) {
							$_var_21[$_var_16]['getmoney'] = $_var_23[$_var_18]['lvtwo'];
						} else {
							if ($_var_21[$_var_16]['lv'] == 3) {
								$_var_21[$_var_16]['getmoney'] = $_var_23[$_var_18]['lvtress'];
							} else {
								if ($_var_21[$_var_16]['lv'] == 4) {
									$_var_21[$_var_16]['getmoney'] = $_var_23[$_var_18]['lvfour'];
								}
							}
						}
					}
					break;
				} else {
					$_var_21[$_var_16]['getmoney'] = 0;
				}
			}
		}
		$_var_24 = 0;
		for ($_var_16 = 0; $_var_16 < count($_var_21); $_var_16++) {
			$_var_24 += $_var_21[$_var_16]['getmoney'];
		}
		return $_var_24;
	}
	public final function chuangguan()
	{
		$_var_25 = 'select * from z4r5jk12_hytzjlrule where money>0';
		$this->dataa = $this->getRows($_var_25);
		$this->display('score/vipfanli.php');
	}
	public final function fanxianvip()
	{
		$_var_26 = $this->user['uid'];
		$_var_27 = $this->user['username'];
		$_var_28 = "select vipjjtoday from z4r5jk12_members where uid={$_var_26}";
		$_var_29 = $this->getRows($_var_28);
		if ($_var_29[0]['vipjjtoday'] == 1) {
			echo 'o';
			die;
		}
		$_var_30 = date('Y-m-d H') . ':00:00';
		$_var_28 = "select sum(mode*beiShu*actionNum) allmoney from z4r5jk12_bets where uid={$_var_26} and actionTime > UNIX_TIMESTAMP('{$_var_30}') group by uid";
		$_var_31 = $this->getRow($_var_28);
		$_var_32 = $_var_31['allmoney'];
		$_var_28 = 'select * from z4r5jk12_hytzjlrule where money>0 order by money desc';
		$_var_33 = $this->getRows($_var_28);
		for ($_var_34 = 0; $_var_34 < count($_var_33); $_var_34++) {
			$_var_35 = $_var_33[$_var_34];
			if ($_var_35['money'] <= $_var_32) {
				if ($this->user['grade'] == 1) {
					if ($_var_35['yi'] > $_var_36) {
						$_var_36 = $_var_35['yi'];
					}
				} else {
					if ($this->user['grade'] == 2) {
						if ($_var_35['er'] > $_var_36) {
							$_var_36 = $_var_35['er'];
						}
					} else {
						if ($this->user['grade'] == 3) {
							if ($_var_37['san'] > $_var_36) {
								$_var_36 = $_var_35['san'];
							}
						} else {
							if ($this->user['grade'] == 4) {
								if ($_var_35['si'] > $_var_36) {
									$_var_36 = $_var_35['si'];
								}
							} else {
								if ($this->user['grade'] == 5) {
									if ($_var_35['wu'] > $_var_36) {
										$_var_36 = $_var_35['wu'];
									}
								} else {
									if ($this->user['grade'] == 6) {
										if ($_var_35['liu'] > $_var_36) {
											$_var_36 = $_var_35['liu'];
										}
									} else {
										if ($this->user['grade'] == 7) {
											if ($_var_35['qi'] > $_var_36) {
												$_var_36 = $_var_35['qi'];
											}
										} else {
											if ($this->user['grade'] == 8) {
												if ($_var_35['ba'] > $_var_36) {
													$_var_36 = $_var_35['ba'];
												}
											} else {
												if ($this->user['grade'] >= 9) {
													if ($_var_35['jiu'] > $_var_36) {
														$_var_36 = $_var_35['jiu'];
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		if (!$_var_36) {
			echo 'n';
			die;
		}
		$_var_28 = "update z4r5jk12_members set coin=coin+{$_var_36},vipjjtoday=1 where uid={$_var_26}";
		$this->exec($_var_28);
		$_var_28 = "select coin from z4r5jk12_members where uid={$_var_26}";
		$_var_38 = $this->getRows($_var_28);
		$_var_39 = $_var_38[0]['coin'];
		$_var_40 = time();
		$_var_28 = "insert into z4r5jk12_coin_log (actionTime,uid,liqType,coin,userCoin)values({$_var_40},{$_var_26},'58',{$_var_36},{$_var_39})";
		$this->exec($_var_28);
		$_var_28 = "insert into z4r5jk12_hytzjl_log (uid,username,amount,actionTime)values({$_var_26},'{$_var_27}',{$_var_36},'{$_var_40}')";
		$this->exec($_var_28);
		echo 'y';
		die;
	}
	public final function goods($_var_41 = null, $_var_42 = null)
	{
		if ($_var_41) {
			$this->scoretype = $_var_41;
		}
		if ($_var_42) {
			$this->limittype = $_var_42;
		}
		$_var_43 = "select * from {$this->prename}score_goods where enable=1 and startTime<={$this->time} and ";
		switch ($this->scoretype) {
			case 'current':
				switch ($this->limittype) {
					case 'all':
						$_var_43 .= "(stopTime>{$this->time} or stopTime=0)";
						break;
					case 'time':
						$_var_43 .= "stopTime>{$this->time} and sum=0";
						break;
					case 'number':
						$_var_43 .= 'sum>0 and surplus>0 and stopTime=0';
						break;
					case 'both':
						$_var_43 .= "stopTime>{$this->time} and sum>0";
						break;
					case 'none':
						$_var_43 .= 'stopTime=0 and sum=0';
						break;
					default:
						throw new Exception('参数出错');
				}
				break;
			case 'old':
				switch ($this->limittype) {
					case 'all':
						$_var_43 .= "((stopTime<{$this->time} and stopTime<>0) or (sum>0 and surplus=0))";
						break;
					case 'time':
						$_var_43 .= "stopTime<{$this->time} and sum=0";
						break;
					case 'number':
						$_var_43 .= 'sum>0 and surplus=0';
						break;
					case 'both':
						$_var_43 .= "stopTime>0 and (stopTime<{$this->time} or (sum>0 and surplus=0))";
						break;
					default:
						throw new Exception('参数出错');
				}
				break;
			case 'me':
				$_var_43 = "select s.id swapId, s.state, g.* from {$this->prename}score_swap s, {$this->prename}score_goods g where s.goodId=g.id and s.uid={$this->user['uid']} and ";
				switch ($this->limittype) {
					case 'current':
						$_var_43 .= 'state between 1 and 2';
						break;
					case 'history':
						$_var_43 .= 'state=0';
						break;
					default:
						throw new Exception('参数出错');
				}
				break;
			default:
				throw new Exception('参数出错');
				break;
		}
		$_var_43 .= ' order by price desc';
		$_var_44 = $this->getPage($_var_43, $this->page, $this->pageSize);
		$this->display('score/list.php', 0, $_var_44);
	}
	public final function swap($_var_45)
	{
		$_var_45 = intval($_var_45);
		$_var_46 = $this->getRow("select * from {$this->prename}score_goods where id=?", $_var_45);
		$this->display('score/swap.php', 0, $_var_46);
	}
	public final function scoreinfo()
	{
		$this->display('score/reloadscore.php');
	}
	public final function swapGood()
	{
		if (!$_POST) {
			throw new Exception('请求出错');
		}
		$_var_47['goodId'] = intval($_POST['goodId']);
		$_var_47['number'] = $_POST['number'];
		$_var_47['coinpwd'] = $_POST['coinpwd'];
		if (!$_var_47['goodId']) {
			throw new Exception('请求出错');
		}
		if (!ctype_digit($_var_47['number'])) {
			throw new Exception('兑换数量必须为整数');
		}
		if ($_var_47['number'] <= 0) {
			throw new Exception('兑换数量需大于等于1');
		}
		$this->beginTransaction();
		try {
			$_var_48 = "select * from {$this->prename}score_goods where id=?";
			if (!($_var_49 = $this->getRow($_var_48, $_var_47['goodId']))) {
				throw new Exception('兑换商品不存在');
			}
			if ($_var_49['stopTime'] > 0 && $_var_49['stopTime'] < $this->time) {
				throw new Exception('这活动已经过期了');
			}
			if ($_var_49['sum'] > 0 && $_var_49['surplus'] == $_var_49['sum']) {
				throw new Exception('这礼品已经兑换完了');
			}
			$_var_49['score'] = $_var_49['score'] * $_var_47['number'];
			$this->freshSession();
			if ($_var_49['score'] > $this->user['score']) {
				throw new Exception('你拥有积分不足，不能兑换这礼品');
			}
			if (!$this->user['coinPassword']) {
				throw new Exception('你尚未设置资金密码!');
			}
			if (md5($_var_47['coinpwd']) != $this->user['coinPassword']) {
				throw new Exception('资金密码不正确');
			}
			unset($_var_47['coinpwd']);
			$_var_47['swapTime'] = $this->time;
			$_var_47['swapIp'] = $this->ip(!0);
			$_var_47['uid'] = $this->user['uid'];
			$_var_47['score'] = $_var_49['score'];
			if ($_var_49['price'] > 0) {
				$_var_47['state'] = 0;
			}
			if (!$this->insertRow($this->prename . 'score_swap', $_var_47)) {
				throw new Exception('兑换礼品出错');
			}
			$_var_48 = "update {$this->prename}members set score=score-{$_var_49['score']} where uid=?";
			if (!$this->update($_var_48, $this->user['uid'])) {
				throw new Exception('兑换礼品出错');
			}
			if ($_var_49['sum'] > 0) {
				$_var_48 = "update {$this->prename}score_goods set surplus=surplus+1,persons=persons+1 where id=?";
				if (!$this->update($_var_48, $_var_49['id'])) {
					throw new Exception('兑换礼品出错');
				}
			}
			if ($_var_49['price'] > 0) {
				$_var_50 = $_var_49['price'] * $_var_47['number'];
				$this->addCoin(array('uid' => $this->user['uid'], 'coin' => $_var_50, 'liqType' => 57, 'extfield0' => 0, 'extfield1' => 0, 'info' => '积分兑换'));
			}
			$this->commit();
			return '兑换礼品成功';
		} catch (Exception $_var_51) {
			$this->rollBack();
			throw $_var_51;
		}
	}
	public final function setSwapState($_var_52)
	{
		if (!($_var_52 = $GLOBALS[_func_0][74]($_var_52))) {
			throw new Exception($GLOBALS[_func_0][77]);
		}
		if (!($_var_53 = $this->getRow("select * from {$this->prename}score_swap where id={$_var_52}"))) {
			throw new Exception($GLOBALS[_func_0][77]);
		}
		if ($_var_53[$GLOBALS[_func_0][68]] != $this->user[$GLOBALS[_func_0][68]]) {
			throw new Exception($GLOBALS[_func_0][109]);
		}
		if ($_var_53[$GLOBALS[_func_0][98]] == 0) {
			throw new Exception($GLOBALS[_func_0][110]);
		}
		if ($_var_53[$GLOBALS[_func_0][98]] == 3) {
			throw new Exception($GLOBALS[_func_0][111]);
		}
		if ($_var_53[$GLOBALS[_func_0][98]] == 1) {
			$_var_54 = $GLOBALS[_func_0][112]($_var_53[$GLOBALS[_func_0][89]] * $this->payout);
			$_var_55 = "update {$this->prename}members u, {$this->prename}score_swap s set u.score=u.score+{$_var_54}, s.state=3 where u.uid=s.uid and s.id={$_var_52}";
		} elseif ($_var_53[$GLOBALS[_func_0][98]] == 2) {
			$_var_55 = "update {$this->prename}score_swap set state=0 where id={$_var_52}";
		} else {
			throw new Exception($GLOBALS[_func_0][77]);
		}
		if ($this->update($_var_55)) {
			return $GLOBALS[_func_0][113];
		} else {
			throw new Exception($GLOBALS[_func_0][77]);
		}
	}
	public function formatGoodTime($_var_56, $_var_57)
	{
		if ($this->time < $_var_56) {
			return '等待中';
		}
		if ($_var_57 && $_var_57 < $this->time) {
			return '已结束';
		}
		if (!$_var_57) {
			return '';
		}
		$_var_58 = $_var_57 - $this->time;
		if ($_var_58 > 24 * 3600) {
			$_var_59 = floor($_var_58 / (24 * 3600)) . '天';
			$_var_58 %= 24 * 3600;
		}
		if ($_var_58 > 3600) {
			$_var_59 .= floor($_var_58 / 3600) . '时';
			$_var_58 %= 3600;
		}
		$_var_59 .= floor($_var_58 / 60) . '分';
		return $this->CsubStr($_var_59, 0, 6, '');
	}
	public final function rotate()
	{
		$this->display('score/dzp.php');
	}
	public final function rotateEvent()
	{
		$this->getdzpSettings;
		$_var_60 = $this->dzpsettings['score'];
		$_var_61 = array();
		$_var_62 = array();
		if ($this->user['score'] < $_var_60) {
			$_var_63['angle'] = 0;
			$_var_63['prize'] = '你拥有积分不足，不能参加幸运大转盘抽奖活动！';
			return $_var_63;
		}
		if (!$this->dzpsettings['switchWeb']) {
			$_var_63['angle'] = 0;
			$_var_63['prize'] = '幸运大转盘活动未开启，敬请关注！';
			return $_var_63;
		}
		$_var_64 = array('0' => array('id' => 1, 'min' => 289, 'max' => 323, 'prize' => $this->dzpsettings['goods289323'], 'v' => $this->dzpsettings['chance289323'], 'j' => $this->dzpsettings['coin289323'], 'w' => $this->dzpsettings['shiwu289323']), '1' => array('id' => 2, 'min' => 181, 'max' => 215, 'prize' => $this->dzpsettings['goods181215'], 'v' => $this->dzpsettings['chance181215'], 'j' => $this->dzpsettings['coin181215'], 'w' => $this->dzpsettings['shiwu181215']), '2' => array('id' => 3, 'min' => 37, 'max' => 71, 'prize' => $this->dzpsettings['goods3771'], 'v' => $this->dzpsettings['chance3771'], 'j' => $this->dzpsettings['coin3771'], 'w' => $this->dzpsettings['shiwu3771']), '3' => array('id' => 4, 'min' => 73, 'max' => 107, 'prize' => $this->dzpsettings['goods73107'], 'v' => $this->dzpsettings['chance73107'], 'j' => $this->dzpsettings['coin73107'], 'w' => $this->dzpsettings['shiwu73107']), '4' => array('id' => 5, 'min' => 253, 'max' => 287, 'prize' => $this->dzpsettings['goods253287'], 'v' => $this->dzpsettings['chance253287'], 'j' => $this->dzpsettings['coin253287'], 'w' => $this->dzpsettings['shiwu253287']), '5' => array('id' => 6, 'min' => 0, 'max' => 35, 'prize' => $this->dzpsettings['goods035'], 'v' => $this->dzpsettings['chance035'], 'j' => $this->dzpsettings['coin035'], 'w' => $this->dzpsettings['shiwu035']), '6' => array('id' => 7, 'min' => 145, 'max' => 179, 'prize' => $this->dzpsettings['goods145179'], 'v' => $this->dzpsettings['chance145179'], 'j' => $this->dzpsettings['coin145179'], 'w' => $this->dzpsettings['shiwu145179']), '7' => array('id' => 8, 'min' => 109, 'max' => 143, 'prize' => $this->dzpsettings['goods109143'], 'v' => $this->dzpsettings['chance109143'], 'j' => $this->dzpsettings['coin109143'], 'w' => $this->dzpsettings['shiwu109143']), '8' => array('id' => 9, 'min' => 217, 'max' => 251, 'prize' => $this->dzpsettings['goods217251'], 'v' => $this->dzpsettings['chance217251'], 'j' => $this->dzpsettings['coin217251'], 'w' => $this->dzpsettings['shiwu217251']), '9' => array('id' => 10, 'min' => 325, 'max' => 359, 'prize' => $this->dzpsettings['goods325359'], 'v' => $this->dzpsettings['chance325359'], 'j' => $this->dzpsettings['coin325359'], 'w' => $this->dzpsettings['shiwu325359']));
		foreach ($_var_64 as $_var_65 => $_var_66) {
			$_var_67[$_var_66['id']] = $_var_66['v'];
			if ($_var_66['j'] > 0) {
				array_push($_var_61, $_var_66['id']);
			}
			if ($_var_66['w'] > 0) {
				array_push($_var_62, $_var_66['id']);
			}
		}
		$_var_68 = $this->getRand($_var_67);
		$_var_69 = $_var_64[$_var_68 - 1];
		$_var_70 = $_var_69['min'];
		$_var_71 = $_var_69['max'];
		$_var_63['angle'] = mt_rand($_var_70, $_var_71);
		$_var_63['prize'] = $_var_69['prize'];
		$this->beginTransaction();
		try {
			$_var_72 = "update {$this->prename}members set score=score-{$_var_60} where uid=?";
			if (!$this->update($_var_72, $this->user['uid'])) {
				$_var_63['angle'] = 0;
				$_var_63['prize'] = '内部出错，请重新操作!';
				return $_var_63;
			}
			if (in_array($_var_68, $_var_61)) {
				$this->addCoin(array('uid' => $this->user['uid'], 'coin' => $_var_69['j'], 'liqType' => 120, 'extfield0' => 0, 'extfield1' => 0, 'info' => '大转盘奖金'));
				$_var_73 = array('uid' => $this->user['uid'], 'info' => $_var_69['prize'], 'state' => 0, 'swapTime' => $this->time, 'swapIp' => $this->ip(!0), 'coin' => $_var_69['j'], 'score' => $this->user['score'] - $_var_60, 'xscore' => $_var_60, 'enable' => 1);
				if (!$this->insertRow($this->prename . 'dzp_swap', $_var_73)) {
					$_var_63['angle'] = 0;
					$_var_63['prize'] = '内部出错，请重新操作!';
					return $_var_63;
				}
			} else {
				if ($_var_68 == 8) {
					$_var_72 = "update {$this->prename}members set score=score+{$_var_60} where uid=?";
					if (!$this->update($_var_72, $this->user['uid'])) {
						$_var_63['angle'] = 0;
						$_var_63['prize'] = '内部出错，请重新操作!';
						return $_var_63;
					}
				} else {
					if (in_array($_var_68, $_var_62)) {
						$_var_73 = array('uid' => $this->user['uid'], 'info' => $_var_69['prize'], 'state' => 1, 'swapTime' => $this->time, 'swapIp' => $this->ip(!0), 'coin' => $_var_69['j'], 'score' => $this->user['score'] - $_var_60, 'xscore' => $_var_60, 'enable' => 1);
						if (!$this->insertRow($this->prename . 'dzp_swap', $_var_73)) {
							$_var_63['angle'] = 0;
							$_var_63['prize'] = '内部出错，请重新操作!';
							return $_var_63;
						}
					}
				}
			}
			$this->commit();
			return $_var_63;
		} catch (Exception $_var_74) {
			$this->rollBack();
			throw $_var_74;
		}
	}
	public final function dodbqb()
	{
		$this->display('score/dodbqb.php');
	}
	public final function dbqbed()
	{
		$_var_75 = strtotime(date('Y-m-d 00:00:00', $this->time));
		$_var_76 = strtotime(date('Y-m-d ', $this->time) . $this->dbqbsettings['FromTime'] . ':00');
		$_var_77 = strtotime(date('Y-m-d ', $this->time) . $this->dbqbsettings['ToTime'] . ':00');
		if (!$this->dbqbsettings['switchWeb']) {
			throw new Exception('幸运砸蛋活动已下线，敬请期待!');
		}
		if ($this->time < $_var_76 || $this->time > $_var_77) {
			throw new Exception('不在活动时间段内，无法参加!');
		}
		if ($this->user['coin'] < $this->dbqbsettings['scoin']) {
			throw new Exception('账户余额小于' . $this->dbqbsettings['scoin'] . '元，无法参加!');
		}
		$_var_78 = number_format($this->getValue("select sum(beiShu * mode * actionNum) from {$this->prename}bets where actionTime > ? and uid={$this->user['uid']} and isDelete=0", $_var_75), 2);
		if ($_var_78 < floatval($this->dbqbsettings['xcoin'])) {
			throw new Exception('今日消费不满' . $this->dbqbsettings['xcoin'] . '元，无法参加!');
		}
		if ($this->dbqbsettings['num'] <= 0) {
			throw new Exception('很遗憾！金蛋已被砸光，请等待下一场！');
		}
		$_var_79 = "update {$this->prename}dbqbparams SET value=value-1 where name='num'";
		$_var_80 = "select state from {$this->prename}dbqb_swap where uid={$this->user['uid']} and  swapTime>{$_var_75}";
		$_var_81 = "select swapIp from {$this->prename}dbqb_swap where uid={$this->user['uid']} and  swapTime>{$_var_75}";
		if ($this->getValue($_var_80)) {
			throw new Exception('很遗憾！您今日已参加过活动，请等待下一场！');
		}
		if ($this->ip(!0) == $this->getValue($_var_81)) {
			throw new Exception('很遗憾！每个IP，每天只允许一个帐户参加活动！');
		}
		$_var_82 = explode('*', $this->dbqbsettings['value']);
		$_var_83 = count($_var_82);
		$_var_84 = $_var_82[mt_rand(0, $_var_83)];
		$this->beginTransaction();
		try {
			$this->addCoin(array('uid' => $this->user['uid'], 'coin' => $_var_84, 'liqType' => 130, 'extfield0' => 0, 'extfield1' => 0, 'info' => '幸运砸蛋奖金'));
			$_var_85 = array('uid' => $this->user['uid'], 'info' => $_var_84 . '元奖金', 'swapTime' => $this->time, 'state' => 1, 'swapIp' => $this->ip(!0), 'coin' => $_var_84, 'enable' => 1);
			$this->query($_var_79);
			$this->insertRow($this->prename . 'dbqb_swap', $_var_85);
			$this->commit();
			return '恭喜你，砸到一个' . $_var_84 . '元的金蛋';
		} catch (Exception $_var_86) {
			$this->rollBack();
			throw $_var_86;
		}
	}
	public final function dodzyh()
	{
		$this->display('score/dodzyh.php');
	}
	public final function dzyhck()
	{
		$this->display('score/dzyhck.php');
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
	
		public final function rml0($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('index/game-played/k3_2tx.php', 0 , $id);
	}
	public final function cml0($id){
		$this->getTypes();
		$this->getPlayeds();
		$this->display('index/game-played/k3_3fx.php', 0 , $id);
	}
	
	public final function dzyhtk()
	{
		$_var_87 = $this->dzyhsettings['ckdate1'] * 24;
		$_var_88 = $this->dzyhsettings['cklv1'];
		$_var_89 = $this->dzyhsettings['ckdate2'] * 24;
		$_var_90 = $this->dzyhsettings['cklv2'];
		$_var_91 = $this->dzyhsettings['ckdate3'] * 24;
		$_var_92 = $this->dzyhsettings['cklv3'];
		$_var_93 = $this->dzyhsettings['ckdate4'] * 24 * 30;
		$_var_94 = $this->dzyhsettings['cklv4'];
		$_var_95 = $this->dzyhsettings['ckdate5'] * 24 * 30 * 12;
		$_var_96 = $this->dzyhsettings['cklv5'];
		$_var_97 = array($_var_87, $_var_89, $_var_91, $_var_93, $_var_95);
		sort($_var_97);
		$_var_98 = array($_var_88, $_var_90, $_var_92, $_var_94, $_var_96);
		sort($_var_98);
		$_var_99 = "select ck_money,time,username from {$this->prename}dzyh_ck_swap where uid={$this->user['uid']} and isdelete=0 and state=0";
		if ($_var_100 = $this->getRow($_var_99)) {
			$_var_101 = ($this->time - $_var_100['time']) / 3600;
		} else {
			$_var_101 = 0;
			$_var_100['ck_money'] = 0;
		}
		if ($_var_101 < $this->dzyhsettings['ckzdsj']) {
			$_var_102 = 0;
			$_var_103 = 0;
		} else {
			if ($_var_101 > $this->dzyhsettings['ckzdsj'] && $_var_101 >= $_var_97[0] && $_var_101 < $_var_97[1]) {
				$_var_102 = $_var_98[0];
				$_var_103 = $_var_100['ck_money'] * $_var_98[0] / 100 * $_var_97[0] / 24;
			} else {
				if ($_var_101 >= $_var_97[1] && $_var_101 < $_var_97[2]) {
					$_var_102 = $_var_98[1];
					$_var_103 = $_var_100['ck_money'] * $_var_98[1] / 100 * $_var_97[1] / 24;
				} else {
					if ($_var_101 >= $_var_97[2] && $_var_101 < $_var_97[3]) {
						$_var_102 = $_var_98[2];
						$_var_103 = $_var_100['ck_money'] * $_var_98[2] / 100 * $_var_97[2] / 24;
					} else {
						if ($_var_101 >= $_var_97[3] && $_var_101 < $_var_97[4]) {
							$_var_102 = $_var_98[3];
							$_var_103 = $_var_100['ck_money'] * $_var_98[3] / 100 * $_var_97[3] / 24;
						} else {
							if ($_var_101 >= $_var_97[4]) {
								$_var_102 = $_var_98[4];
								$_var_103 = $_var_100['ck_money'] * $_var_98[4] / 100 * $_var_97[4] / 24;
							}
						}
					}
				}
			}
		}
		$_var_100['lx'] = $_var_103;
		$this->display('score/dzyhtk.php', 0, $_var_100);
	}
	public final function dzyhcked()
	{
		$_var_104 = floatval($_POST['ckmoney']);
		if ($_var_104 <= 0) {
			throw new Exception('输入的存款金额错误，请重新输入！');
		}
		if ($_var_104 <$this->dzyhsettings['ckzdje']) { 
		    throw new Exception("最低存款需要".$this->dzyhsettings['ckzdje']."元，请重新输入！");
		}
		if ($_var_104 >$this->dzyhsettings['ckzgje']) {
			throw new Exception("超出最高存款".$this->dzyhsettings['ckzgje']."元，请重新输入！");
		}
		if (md5($_POST['coinpassword']) != $this->user['coinPassword']) {
			throw new Exception('资金密码错误,请核对后再操作!');
		}
		if (strtolower($_POST['vcode']) != $_SESSION[$this->vcodeSessionName]) {
			throw new Exception('验证码不正确。');
		}
		unset($_SESSION[$this->vcodeSessionName]);
		if (!$this->dzyhsettings['switchck']) {
			throw new Exception('投资理财存款功能已关闭,详情请联系在线客服！');
		}
		if ($this->getValue("select count(id) from {$this->prename}dzyh_ck_swap where uid={$this->user['uid']} and isdelete=0 and state=0;") >= 1) {
			throw new Exception('对不起！每个用户只能存一笔，您已经有一笔存款,请先取出！');
		}
		if ($this->user['coin'] == 0) {
			throw new Exception('用户余额为零，请先充值！');
		}
		if ($_var_104 > $this->user['coin']) {
			throw new Exception('很遗憾！存款金额大于当前账户余额，无法存款，请先充值！');
		}
		$_var_105 = array('uid' => $this->user['uid'], 'username' => $this->user['username'], 'ck_money' => $_var_104, 'time' => $this->time, 'ip' => $this->ip(!0), 'enable' => 0, 'state' => 0, 'isdelete' => 0);
		if (!$this->insertRow($this->prename . 'dzyh_ck_swap', $_var_105)) {
			throw new Exception('存款失败！请重试');
		}
		$this->addCoin(array('uid' => $this->user['uid'], 'coin' => -$_var_104, 'liqType' => 140, 'extfield0' => 0, 'extfield1' => 0, 'info' => '存入投资理财'));
		return '存款成功!';
	}
	public final function dzyhtked()
	{
		if (md5($_POST['coinpassword']) != $this->user['coinPassword']) {
			throw new Exception('资金密码错误,请核对后再操作!');
		}
		if (strtolower($_POST['vcode']) != $_SESSION[$this->vcodeSessionName]) {
			throw new Exception('验证码不正确。');
		}
		unset($_SESSION[$this->vcodeSessionName]);
		if (!$this->dzyhsettings['switchtk']) {
			throw new Exception('投资理财提款功能已关闭,详情请联系在线客服！');
		}
		if (!$this->getValue("select count(id) from {$this->prename}dzyh_ck_swap where uid={$this->user['uid']} and isdelete=0 and state=0;")) {
			throw new Exception('对不起！您没有存款！');
		}
		if ($this->getValue("select enable from {$this->prename}dzyh_ck_swap where uid={$this->user['uid']} and isdelete=0 and state=0;")) {
			throw new Exception('对不起！您的存款已被冻结,详情请联系在线客服！');
		}
		$_var_106 = $this->dzyhsettings['ckdate1'] * 24;
		$_var_107 = $this->dzyhsettings['cklv1'];
		$_var_108 = $this->dzyhsettings['ckdate2'] * 24;
		$_var_109 = $this->dzyhsettings['cklv2'];
		$_var_110 = $this->dzyhsettings['ckdate3'] * 24;
		$_var_111 = $this->dzyhsettings['cklv3'];
		$_var_112 = $this->dzyhsettings['ckdate4'] * 24 * 30;
		$_var_113 = $this->dzyhsettings['cklv4'];
		$_var_114 = $this->dzyhsettings['ckdate5'] * 24 * 30 * 12;
		$_var_115 = $this->dzyhsettings['cklv5'];
		$_var_116 = array($_var_106, $_var_108, $_var_110, $_var_112, $_var_114);
		sort($_var_116);
		$_var_117 = array($_var_107, $_var_109, $_var_111, $_var_113, $_var_115);
		sort($_var_117);
		$_var_118 = "select ck_money,time,username from {$this->prename}dzyh_ck_swap where uid={$this->user['uid']} and isdelete=0 and state=0";
		if ($_var_119 = $this->getRow($_var_118)) {
			$_var_120 = ($this->time - $_var_119['time']) / 3600;
		} else {
			$_var_120 = 0;
			$_var_119['ck_money'] = 0;
		}
		if ($_var_120 < $this->dzyhsettings['ckzdsj']) {
			$_var_121 = 0;
			$_var_122 = 0;
		} else {
			if ($_var_120 > $this->dzyhsettings['ckzdsj'] && $_var_120 >= $_var_116[0] && $_var_120 < $_var_116[1]) {
				$_var_121 = $_var_117[0];
				$_var_122 = $_var_119['ck_money'] * $_var_117[0] / 100 * $_var_116[0] / 24;
			} else {
				if ($_var_120 >= $_var_116[1] && $_var_120 < $_var_116[2]) {
					$_var_121 = $_var_117[1];
					$_var_122 = $_var_119['ck_money'] * $_var_117[1] / 100 * $_var_116[1] / 24;
				} else {
					if ($_var_120 >= $_var_116[2] && $_var_120 < $_var_116[3]) {
						$_var_121 = $_var_117[2];
						$_var_122 = $_var_119['ck_money'] * $_var_117[2] / 100 * $_var_116[2] / 24;
					} else {
						if ($_var_120 >= $_var_116[3] && $_var_120 < $_var_116[4]) {
							$_var_121 = $_var_117[3];
							$_var_122 = $_var_119['ck_money'] * $_var_117[3] / 100 * $_var_116[3] / 24;
						} else {
							if ($_var_120 >= $_var_116[4]) {
								$_var_121 = $_var_117[4];
								$_var_122 = $_var_119['ck_money'] * $_var_117[4] / 100 * $_var_116[4] / 24;
							}
						}
					}
				}
			}
		}
		$_var_123 = array('uid' => $this->user['uid'], 'username' => $_var_119['username'], 'tk_money' => $_var_119['ck_money'], 'time' => $_var_119['time'], 'tktime' => $this->time, 'lv' => $_var_121, 'lx' => $_var_122, 'ip' => $this->ip(!0), 'isdelete' => 0);
		if (!$this->update("update {$this->prename}dzyh_ck_swap set state=1 where uid={$this->user['uid']}")) {
			throw new Exception('提款失败！请重试');
		}
		if (!$this->insertRow($this->prename . 'dzyh_tk_swap', $_var_123)) {
			throw new Exception('提款失败！请重试');
		}
		$this->addCoin(array('uid' => $this->user['uid'], 'coin' => $_var_119['ck_money'] + $_var_122, 'liqType' => 150, 'extfield0' => 0, 'extfield1' => 0, 'info' => '投资理财提款'));
		return '提款成功!';
	}
}
