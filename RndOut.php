<?php
$rndStr = '';
if(isset($_POST['txtLength']))
{
	$rndSeeds = '';
	$seqStr = '';
	$typeStr = '';
	$bStrong = true;
	$lenPwd = intval($_POST['txtLength']);
	$arrChk = $_POST['chkType'];
	$cntChk = count($arrChk);
	$idxOff = 0;
	$lenSub = 2;
	$rndSeeds = bin2hex(openssl_random_pseudo_bytes($lenPwd * 5 - $cntChk, $bStrong));
	$arrTxt = $_POST['txtPwd'];
	for($i = 0; $i < $cntChk; $i++)
		$typeStr = $typeStr . $arrChk[$i];
	for($i = $cntChk; $i < $lenPwd; $i++)
	{
		$rndNum = intval(substr($rndSeeds, $idxOff, $lenSub), 16);
		$idxOff += $lenSub;
		$typeStr = $typeStr . $arrChk[$rndNum % $cntChk];
	}
	$lenSub = 4;
	for($i = 0; $i < $lenPwd; $i++)
	{
		$rndNum = intval(substr($rndSeeds, $idxOff, $lenSub), 16);
		$idxOff += $lenSub;
		$idx2Pick = $rndNum % strlen($typeStr);
		$seqStr = $seqStr . substr($typeStr, $idx2Pick, 1);
		$typeStr = substr($typeStr, 0, $idx2Pick) . substr($typeStr, $idx2Pick + 1);
	}
	for($i = 0; $i < $lenPwd; $i++)
	{
		$rndNum = intval(substr($rndSeeds, $idxOff, $lenSub), 16);
		$idxOff += $lenSub;
		$idxArrPwd = intval(substr($seqStr, $i, 1));
		$dbgStr = $arrTxt[$idxArrPwd];
		$idx2Pick = $rndNum % strlen($arrTxt[$idxArrPwd]);
		$str2Append = substr($arrTxt[$idxArrPwd], $idx2Pick, 1);
		//if ($str2Append == '\"')
		//	$str2Append = '\\' . $str2Append;
		$rndStr = $rndStr . $str2Append;
	}
}
echo '<center><h3>Output Random String:</h3><input type=text size=60 readonly value=\'' . htmlspecialchars($rndStr) . '\'></center>';
?>