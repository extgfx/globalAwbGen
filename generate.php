<?php
$j = 1;

$fish = "
      /`·.¸
     /¸...¸`:·
 ¸.·´  ¸   `·.¸.·´)
: © ):´;      ¸  {	 S G B ?
 `·.¸ `·  ¸.·´\`·¸)
     `\,;´´\¸.·´
============================================\n";
$banner = "	 [+] [fb.me/extgfx] [+]
============================================\n\n";
echo $fish;
echo $banner;


while (true) {
	$string = array('LP','UB');
	$k = array_rand($string);
	$v = $string[$k];

	$randAWB = 'LP19'.random(7,0).'SG';
	$check = Curi('https://global.cainiao.com/detail.htm?mailNoList='.$randAWB.'&spm=a3708.7860688.0.d01');
	$getdata =html_entity_decode(getStr($check[1],'<textarea style="display: none;" id="waybill_list_val_box">','</textarea>'));

	if (strpos($getdata, 'latestTrackingInfo')) {
		$WBdata = json_decode($getdata);
		// print_r($WBdata);

		$latest = $WBdata->data[0]->latestTrackingInfo->desc;
		$dest = $WBdata->data[0]->destCountry;
		$org = $WBdata->data[0]->originCountry;
		$status = $WBdata->data[0]->status;
		$time = $WBdata->data[0]->latestTrackingInfo->time;
		$awb = $latestinfo = $WBdata->data[0]->mailNo;

		if (1 > 0){

			if (strpos($latest, "livered") !== false) {
				if (strpos($time, "-05-") !== false ) {
					echo "\033[32m$j. $status | VALID | $awb : $latest  : $org : $dest : $time \033[0m\n";
					@ob_flush();
					flush();
					file_put_contents('a.txt',"$awb".PHP_EOL,FILE_APPEND);
					$j++;
				}
			}
		}

	} else {
		echo "\033[31m$j. $randAWB : Invalid Waybill\033[0m\n";
		@ob_flush();
		flush();
		$j++;

	}
}




function Curi($url, $fields=false, $cookie=false, $httpheader=false, $proxy=false, $encoding=false, $timeout=false, $useragent=false)
{ 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if($useragent !== false)
	{
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	}
	if($fields !== false)
	{ 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	}
	if($encoding !== false)
	{ 
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	}
	if($cookie !== false)
	{ 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	}
	if($httpheader !== false)
	{ 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	}
	if($proxy !== false)
	{ 
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	}
	if($timeout !== false)
	{ 
          // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
          // curl_setopt($ch, CURLOPT_TIMEOUT, 6); //timeout in seconds     
	}
	$response = curl_exec($ch);
	$header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return array($header, $body, $code);
}
function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
} 
function random($length,$a) 
{
	$str = "";
	if ($a == 0) {
		$characters = array_merge(range('0','9'));
	}elseif ($a == 1) {
		$characters = array_merge(range('0','9'),range('a','z'));
	}
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
?>