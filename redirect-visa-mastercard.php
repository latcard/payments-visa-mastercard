<?php
$MerchantId = '';
$SoapLogin = '';
$SoapPassword = '';
$Terminal = '';
$Currency = '';
$Language = 'en';

$EndPoint = 'https://endpoint-latcard-gateway.com';

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;	
curl_setopt($ch, CURLOPT_USERPWD, $SoapLogin . ':' . $SoapPassword);
curl_setopt($ch, CURLOPT_HEADER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_URL, $EndPoint);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($httpCode == '200') 
{
	$xml = '<?xml version="1.0" encoding="utf-8"?>
	<PayReqOne>
	<MERCHANT>' . $MerchantId . '</MERCHANT>
	<TERMINAL>' . $Terminal . '</TERMINAL>
	<ORDER_ID>123</ORDER_ID>
	<ORDER_DESC>Order number description</ORDER_DESC>
	<FIRST_NAME>Firstname</FIRST_NAME>
	<LAST_NAME>Lastname</LAST_NAME>
	<ADDRESS>Address</ADDRESS>
	<CITY>City</CITY>
	<EMAIL>email@email.com</EMAIL>
	<ZIP_CODE>zip-code</ZIP_CODE>
	<COUNTRY_CODE>LV</COUNTRY_CODE>
	<AMOUNT>12.54</AMOUNT>
	<CURRENCY>' . $Currency . '</CURRENCY>
	<LANG>' . $Language . '</LANG>
	<TYPE_PAYMENT>100</TYPE_PAYMENT>
	</PayReqOne>'; 

	$client = new SoapClient($EndPoint, 
	array('trace' => true, 
	'login' => $SoapLogin, 		
	'password' => $SoapPassword,
	'exceptions' => true
	));	

	//returns html code with JS redirect to payment page
	echo $client->start($xml); 
} 
?>
