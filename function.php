<?php
function miyu($num){
	if($num=='dw'){
		$miyu = ['๐ฑ','๐ถ','๐ท','๐'];
	}elseif($num=='my'){
		$miyu = ['ๅต','ๅช','ๅ','๏ฝ'];
	}elseif($num=='sy'){
		$miyu = ['ๅท','ๅ','ๅ','๏ฝ'];
	}elseif($num=='gy'){
		$miyu = ['ๆบ','ๆฑช','ๅ','๏ฝ'];
	}elseif($num=='fh'){
		$miyu = ['ยท','๏ฝ','-','`'];
	}elseif($num=='sz'){
		$miyu = ['6','9','8','5'];
	}elseif($num=='zm'){
		$miyu = ['a','b','c','d'];
	}elseif($num=='ay'){
		$miyu = ['ๆ','็ฑ','ไฝ ','๏ฝ'];
	}elseif($num=='sg'){
		$miyu = ['๐','๐','๐','๐'];
	}elseif($num=='bq'){
		$miyu = ['๐','๐','๐','๐'];
	}elseif($num=='ss'){
		$miyu = ['๐','๐','๐','๐'];
	}
	return $miyu;
}


function encode($str,$miyu){
	$code = null;
	$hexArray = str_split_unicode(bin2hex($str));
	foreach ($hexArray as $k => $v) {
		$x = base_convert($v, 16, 10) + $k % 16;
		if ($x >= 16) {
			$x -= 16;
		}
		$code .= $miyu[($x / 4)] . $miyu[$x % 4];
	}
	return $code;
}

function decode($str){
	if(strstr($str,'๐ฑ')){
		$miyu = miyu('dw');
	}elseif(strstr($str,'ๅต')){
		$miyu = miyu('my');
	}elseif(strstr($str,'ๅท')){
		$miyu = miyu('sy');
	}elseif(strstr($str,'ๆบ')){
		$miyu = miyu('gy');
	}elseif(strstr($str,'ยท')){
		$miyu = miyu('fh');
	}elseif(strstr($str,'6')){
		$miyu = miyu('sz');
	}elseif(strstr($str,'a')){
		$miyu = miyu('zm');
	}elseif(strstr($str,'ๆ')){
		$miyu = miyu('ay');
	}elseif(strstr($str,'๐')){
		$miyu = miyu('sg');
	}elseif(strstr($str,'๐')){
		$miyu = miyu('bq');
	}elseif(strstr($str,'๐')){
		$miyu = miyu('ss');
	}
	$code = null;
	$hexArray = str_split_unicode($str);
	$n = count($hexArray);
	for ($i = 0; $i < $n; $i++) {
		if ($i % 2 == 0) {
			if (empty($hexArray[$i + 1])) {
				break;
			}
			$A = array_search($hexArray[$i], $miyu);
			$B = array_search($hexArray[$i + 1], $miyu);
			$x = (($A * 4) + $B) - (($i / 2) % 16);
			if ($x < 0) {
				$x += 16;
			}
			$code .= dechex($x);
		}
	}
	return pack("H*", $code);
}

function str_split_unicode($str, $l = 0){
	if ($l > 0) {
		$ret = array();
		$len = mb_strlen($str, "UTF-8");
		for ($i = 0; $i < $len; $i += $l) {
			$ret[] = mb_substr($str, $i, $l, "UTF-8");
		}
		return $ret;
	}
	return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function daddslashes($string, $force = 0, $strip = FALSE) {
        !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        if(!MAGIC_QUOTES_GPC || $force) {
            if(is_array($string)) {
                foreach($string as $key => $val) {
                    $string[$key] = daddslashes($val, $force, $strip);
                }
            } else {
                $string = addslashes($strip ? stripslashes($string) : $string);
            }
        }
        return $string;
    }
?>