<?php
// script created by : will pratama - facebook.com/yaelahhwil - 18-05-2019
 
date_default_timezone_set("Asia/Jakarta");
$date = date("H:i:s Y-m-d");
class qriket extends modules
{
	private $BASE_URL = "https://goldcloudbluesky.com";
 
	public function login($email, $password)
	{
		$url = $this->BASE_URL."/app/login";
		$post = '{"email":"'.$email.'","password":"'.$password.'"}';
		$headers = explode("\n", "device-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
 
		$login = $this->curl($url, $post, false, false, $headers);
		$obj = json_decode($login);
 
		return $login;
	}
 
	public function sendOtp($phone)
	{
		$url = $this->BASE_URL."/app/sms/verify";
		$post = '{"phoneNumber":"'.str_replace("08", "+628", str_replace("628", "+628", $phone)).'"}';
		$headers = explode("\n", "device-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
 
		$sendOtp = $this->curl($url, $post, false, false, $headers);
		$obj = json_decode($sendOtp);
 
		return $sendOtp;
	}
 
	public function registerAccount($codereff, $phoneNumber = null, $otepepekuenakontolan = null)
	{
		$firstName = $this->randNama()['first'];
		$lastName = $this->randNama()['last'];
		$email = $this->randNama()['email'];
		$password = $this->randNama()['password'];
 
		if($codereff == "n")
		{
			$phoneNumbers = "+6281".$this->randStr("angka", "10");
			$post = '{"email":"'.$email.'","firstName":"'.$firstName.'","lastName":"'.$lastName.'","password":"'.$password.'","phoneNumber":"'.$phoneNumbers.'","utcOffset":480}';
		}else{
			$url = $this->BASE_URL."/app/sms/verify";
			$post = '{"code":"'.trim($otepepekuenakontolan).'","phoneNumber":"'.str_replace("08", "+628", str_replace("628", "+628", $phoneNumber)).'"}';
			$headers = explode("\n", "device-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
			$verifMemek = $this->curl($url, $post, false, false, $headers, 'PUT');
			print $verifMemek;
 
			$post = '{"email":"'.$email.'","firstName":"'.$firstName.'","lastName":"'.$lastName.'","password":"'.$password.'","phoneNumber":"'.str_replace("08", "+628", str_replace("628", "+628", $phoneNumber)).'","referralCode":"'.$codereff.'","utcOffset":480}';
		}
 
		$url = $this->BASE_URL."/app/register";
		$headers = explode("\n", "device-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
 
		$registerAccount = $this->curl($url, $post, false, false, $headers);
		$obj = json_decode($registerAccount);
 
		@$userId = $obj->account->user->id;
		@$emailResponse = $obj->account->user->email;
		@$accessToken = $obj->auth->jwt->accessToken;
		if(!empty($accessToken))
		{
		 	print PHP_EOL."Success Register!, ".$emailResponse."|".$password;
		 	$this->fwrite("akunQriket.txt", $userId."|".$emailResponse."|".$password."|".$accessToken.PHP_EOL);
		}else{
			print PHP_EOL."Failed Register!, Message:".@$obj->errors[0] ? : "null";
		}
	}
 
	public function spinDanGet($accessToken, $amount, $color)
	{
		$headers = explode("\n", "Authorization: Bearer ".$accessToken."\ndevice-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
 
		$url = $this->BASE_URL."/campaigns";
		$post = null;
 
		$getInternal = $this->curl($url, $post, false, false, $headers, 'GET');
		$objI = json_decode($getInternal);
		foreach($objI->campaigns->internal as $a => $internal)
		{
			$campaignInternal = $internal->campaign;
			$networkInternal = $internal->network;
			print $this->getPointSpin($accessToken, $campaignInternal, $networkInternal);
			sleep(80);
			@ob_flush();
			@flush();
		}
 
		$getNetwork = $this->curl($url, $post, false, false, $headers, 'GET');
		$objN = json_decode($getNetwork);
		foreach($objN->campaigns->networks as $b => $networks)
		{
			$campaignNetworks = $networks->campaign;
			$networkNetworks = $networks->network;
			print $this->getPointSpin($accessToken, $campaignNetworks, $networkNetworks);
			sleep(80);
			@ob_flush();
			@flush();
		}	
	}
 
	public function getCampaigns($accessToken)
	{
		$headers = explode("\n", "Authorization: Bearer ".$accessToken."\ndevice-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
 
		$url = $this->BASE_URL."/campaigns";
		$post = null;
 
		$getInternal = $this->curl($url, $post, false, false, $headers, 'GET');
		$objI = json_decode($getInternal);
		foreach($objI->campaigns->internal as $a => $internal)
		{
			$campaignInternal = $internal->campaign;
			$networkInternal = $internal->network;
			print $this->getPointSpin($accessToken, $campaignInternal, $networkInternal);
			sleep(1);
			@ob_flush();
			@flush();
		}
 
		$getNetwork = $this->curl($url, $post, false, false, $headers, 'GET');
		$objN = json_decode($getNetwork);
		foreach($objN->campaigns->networks as $b => $networks)
		{
			$campaignNetworks = $networks->campaign;
			$networkNetworks = $networks->network;
			print $this->getPointSpin($accessToken, $campaignNetworks, $networkNetworks);
			sleep(1);
			@ob_flush();
			@flush();
		}
	}
 
	public function getPointSpin($accessToken, $campaigns, $network)
	{
		while(true)
		{
			$headers = explode("\n", "Authorization: Bearer ".$accessToken."\ndevice-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
			$url = $this->BASE_URL."/campaigns/claim";
			$post = '{"campaign":'.trim($network).',"network":'.trim($network).',"referralGoal":true}';
 
			$getPointSpin = $this->curl($url, $post, false, false, $headers);
			$obj = json_decode($getPointSpin);
 
			@$pointSpin = $obj->balance->spins;
			if(!empty($pointSpin))
			{
				print PHP_EOL."Success Get Point SPIN! : ".$pointSpin;
			}elseif(preg_match('/Internal Server Error/i', $getPointSpin)){
				print PHP_EOL."loading...";
				return false;
			}else{
				print PHP_EOL."limit...";;
				return false;
			}
			sleep(40);
			@ob_flush();
			@flush();
		}
	}
 
	public function spin($accessToken, $amount, $color)
	{
		$headers = explode("\n", "Authorization: Bearer ".$accessToken."\ndevice-type: Android\ndevice-hardware: ".$this->randStr("all", "6")." ".$this->randStr("angka", "4")."\ndevice-version: ".rand(0000, 99999)."\nversion: 3.1.9\nContent-Type: application/json; charset=UTF-8\nHost: goldcloudbluesky.com");
		$url = $this->BASE_URL."/game";
		$post = '{"configHash":"40c5d29a29ce6561db6e5391e49242c5","selectedColor":'.$color.',"wager":{"amount":'.$amount.',"type":"spins"}}';
 
		$spinPertama = $this->curl($url, $post, false, false, $headers);
		$obj = json_decode($spinPertama);
		@$pointSpin = $obj->balance->spins;
 
		if(strpos($spinPertama, '"continue":false'))
		{
			print PHP_EOL."Gagal.. Point : ".$pointSpin;
			sleep(2);
			@ob_flush();
			@flush();
		}elseif(strpos($spinPertama, '"continue":true')){
			@$Guid = $obj->session->GUID;
			@$secret = $obj->session->nextMove->secret;
 
			print PHP_EOL."Berhasil!, ";
			sleep(2);
			@ob_flush();
			@flush();
			$url = $this->BASE_URL."/game";
			$post = '{"GUID":"'.$Guid.'","secret":"'.$secret.'","selectedColor":'.$color.'}';
 
			$spinKedua = $this->curl($url, $post, false, false, $headers, 'PUT');
			$obj = json_decode($spinKedua);
 
			if(strpos($spinKedua, '"continue":false'))
			{
				print "Gagal.. Point : ".$pointSpin;
				sleep(2);
				@ob_flush();
				@flush();
			}elseif(strpos($spinKedua, 'continue":true')){
				@$secretKedua = $obj->session->nextMove->secret;
				print "Berhasil!, ";
				sleep(2);
				@ob_flush();
				@flush();
				$url = $this->BASE_URL."/game/claim";
				$post = '{"GUID":"'.$Guid.'","secret":"'.$secretKedua.'"}';
 
				$claim = $this->curl($url, $post, false, false, $headers, 'PUT');
				$obj = json_decode($claim);
 
				@$getBalance = $obj->prize->amount;
				@$balance = $obj->balance->cash;
				@$sisaPoint = $obj->balance->spins;
 
				if(!empty($getBalance))
				{
					print "Get ".$getBalance."$ / ".$balance."$ / ".$sisaPoint;
					sleep(2);
					@ob_flush();
					@flush();
				}else{
					print "Gagal claim!";
					sleep(2);
					@ob_flush();
					@flush();
				}
			}else{
				print "Kesalahan Pada Spin Kedua..";
				sleep(2);
				@ob_flush();
				@flush();
			}
		}elseif(strpos($spinPertama, '"errors":["Insufficient funds to start new game."]')){
			return PHP_EOL."Insufficient funds to start new game.";
		}else{
			print "Kesalahan Pada Spin Pertama..";
			sleep(2);
			@ob_flush();
			@flush();
		}	
	}
}
 
class modules 
{
	var $ch;
 
	public function curl($url, $params, $cookie, $header, $httpheaders = array(), $request = 'POST', $socks = null)
	{
		$this->ch = curl_init();
			
		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
 
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $request);
 
		if($cookie == true)
		{	
			$cookFile = tempnam('/tmp','cookie.txt');
			curl_setopt($this->ch, CURLOPT_COOKIEJAR, $cookFile);
			curl_setopt($this->ch, CURLOPT_COOKIEFILE, $cookFile);
		}
 
		curl_setopt($this->ch, CURLOPT_HEADER, $header);
		@curl_setopt($this->ch, CURLOPT_HTTPHEADER, $httpheaders);
 
		curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($this->ch, CURLOPT_PROXY, $socks);
		curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
 
		curl_setopt($this->ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		$response = curl_exec($this->ch);
		curl_close($this->ch);
		return $response;
	}
 
	public function randStr($type, $length)	
	{
		$characters = array();
		$characters['angka'] = '0123456789';
		$characters['kapital'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characters['huruf'] = 'abcdefghijklmnopqrstuvwxyz';
		$characters['kapital_angka'] = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characters['huruf_angka'] = '0123456789abcdefghijklmnopqrstuvwxyz';
		$characters['all'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters[$type]);
		$randomString = '';
 
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[$type][rand(0, $charactersLength - 1)];
		}
 
		return $randomString;
 
	}   
 
	public function randNama()
	{
		$get = file_get_contents("https://api.randomuser.me");
		$j = json_decode($get, true);
		$first = @preg_replace("/\b(?!\|)(?!,)(?!\s)\W\b/", "", @iconv('UTF-8', 'ASCII//TRANSLIT', $j['results'][0]['name']['first']));
		$last = @preg_replace("/\b(?!\|)(?!,)(?!\s)\W\b/", "", @iconv('UTF-8', 'ASCII//TRANSLIT', $j['results'][0]['name']['last']));
		$nama = $first .$last.$this->randStr('huruf_angka','2');
		$rand = rand(00000,99999);
		$domain = array("@gmail.com","@yahoo.com","@hotmail.co.id");
		$email = $first.$last.$this->randStr("all", "2").$domain[rand(0, 2)];	
		$nomorhp = "+628".$this->randStr('angka','10')."";
		$password = $first.$this->randStr('huruf_angka','6');	
		if(empty($first) or empty($last))
		{
			$this->randNama();
		}else{
			return array("first" => $first, "last" => $last, "nama" => $nama, "email" => $email, "nope" => $nomorhp, "password" => $password);
		}
	}
 
	public function fwrite($namafile, $data)
	{
		$fh = fopen($namafile, "a");
		fwrite($fh, $data);
		fclose($fh);  
	}
}
 
$qriket = new qriket;
$modules = new modules;
 
print PHP_EOL."===========[!] Menu [!]=============";
print PHP_EOL."[1] Login";
print PHP_EOL."[2] Register Account";
print PHP_EOL."[3] Get Point Spin";
print PHP_EOL."[4] Auto Spin";
print PHP_EOL."[5] Auto Spin + Get Spin";
print PHP_EOL."[6] Exit";
print PHP_EOL."===========[!] Menu [!]=============";
print PHP_EOL."Pilih Menu : ";
 
$menu = trim(fgets(STDIN));
$die = PHP_EOL.json_encode(array('status' => "exit"));
if(!empty($menu))
{
	if($menu == 1 or $menu == "1")
	{
		print PHP_EOL."Masukkan Email|Password : ";
		$empas = trim(fgets(STDIN));
 
		$login = $qriket->login(explode("|", trim($empas))[0], explode("|", trim($empas))[1]);
		print PHP_EOL.$login;
	}elseif($menu == 2 or $menu == "2"){
		print PHP_EOL."With Referral ? y/n : ";
		$yataun = trim(fgetS(STDIN));
		if($yataun == "y")
		{
			print "Input Referral Code : ";
			$reff = trim(fgets(STDIN));
			print "Input Phone number : ";
			$pone = trim(fgets(STDIN));
			$qriket->sendOtp($pone);
			print PHP_EOL."success Send OTP : ".$pone;
			print PHP_EOL."Input OTP Code : ";
			$otepepekuenakontolan = trim(fgets(STDIN));
			print $qriket->registerAccount($reff, $pone, $otepepekuenakontolan);
		}elseif($yataun == "n"){
			print PHP_EOL."Jumlah Register : ";
			$jum = trim(fgets(STDIN));
 
			for($a = 1; $a <= $jum; $a++)
			{
				print $qriket->registerAccount("n");
				sleep(1);
				@ob_flush();
				@flush();
			}
		}	
	}elseif($menu == 3 or $menu == "3"){
		print PHP_EOL."Masukkan Email|Password : ";
		$empas = trim(fgets(STDIN));
 
		$login = $qriket->login(explode("|", trim($empas))[0], explode("|", trim($empas))[1]);
		$obj = json_decode($login);
		@$accessToken = $obj->auth->jwt->accessToken;
		@$first = $obj->account->user->firstName;
		@$last = $obj->account->user->lastName;
		if(!empty($accessToken))
		{
			print PHP_EOL."Welcome : ".$first." ".$last.". Happy Ngebot Gays ^_^".PHP_EOL;
			while(true)
			{
				print $qriket->getCampaigns($accessToken);
				sleep(1);
				@ob_flush();
				@flush();
			}
		}else{
			print PHP_EOL.$login;
		}
	}elseif($menu == 4 or $menu == "4"){
		print PHP_EOL."Masukkan Email|Password : ";
		$empas = trim(fgets(STDIN));
		print "Masukkan Amount Spin : ";
		$amount = trim(fgets(STDIN));
		print "Masukkan Color Spin (0/1) : ";
		$color = trim(fgets(STDIN));
 
		$login = $qriket->login(explode("|", trim($empas))[0], explode("|", trim($empas))[1]);
		$obj = json_decode($login);
		@$accessToken = $obj->auth->jwt->accessToken;
		@$first = $obj->account->user->firstName;
		@$last = $obj->account->user->lastName;
		if(!empty($accessToken))
		{
			print PHP_EOL."Welcome : ".$first." ".$last.". Happy Ngebot Gays ^_^".PHP_EOL;
			while(true)
			{
				print $qriket->spin($accessToken, $amount, $color);
				@ob_flush();
				@flush();
			}
		}else{
			print PHP_EOL.$login;
		}
	}elseif($menu == 5 or $menu == "5"){
		print PHP_EOL."Masukkan Email|Password : ";
		$empas = trim(fgets(STDIN));
		print "Masukkan Amount Spin : ";
		$amount = trim(fgets(STDIN));
		print "Masukkan Color Spin (0/1) : ";
		$color = trim(fgets(STDIN));
 
		$login = $qriket->login(explode("|", trim($empas))[0], explode("|", trim($empas))[1]);
		$obj = json_decode($login);
		@$accessToken = $obj->auth->jwt->accessToken;
		@$first = $obj->account->user->firstName;
		@$last = $obj->account->user->lastName;
		if(!empty($accessToken))
		{
			print PHP_EOL."Welcome : ".$first." ".$last.". Happy Ngebot Gays ^_^".PHP_EOL;
			while(true)
			{
				print $qriket->spinDanGet($accessToken, $amount, $color);
				@ob_flush();
				@flush();
			}
		}else{
			print PHP_EOL.$login;
		}	
	}else{	
		print $die;
	}
}else{
	print $die;
}
 
?>