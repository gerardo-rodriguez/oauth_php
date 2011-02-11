<?php
error_reporting(E_ALL); 
ini_set("display_errors", 1); 

include_once "../library/OAuthStore.php";
include_once "../library/OAuthRequester.php";

// Test of the OAuthStore2Leg 

$key = 'dj0yJmk9dG9KVjI4bFJiNlBvJmQ9WVdrOVVtRlNSMkZ1Tm1zbWNHbzlNell6TkRnNE1EWXkmcz1jb25zdW1lcnNlY3JldCZ4PWNm'; // fill with your public key 
$secret = '40419ad4ddb66b33e804dd0ab234a944840b4851'; // fill with your secret key
$url = "https://api.login.yahoo.com/oauth/v2/get_request_token"; // fill with the url for the oauth service

/*
oauth_nonce=ce2130523f788f313f76314ed3965ea6  
&oauth_timestamp=1202956957  
&oauth_consumer_key=123456891011121314151617181920  
&oauth_signature_method=plaintext  
&oauth_signature=abcdef  
&oauth_version=1.0  
&xoauth_lang_pref="en-us"  
&oauth_callback="http://yoursite.com/callback"
*/
$options = array('consumer_key' => $key, 'consumer_secret' => $secret);
OAuthStore::instance("2Leg", $options);

$method = "GET";
$params = array(
	'oauth_nonce' => 'ce2130523f788f313f76314ed3965ea6',
	'oauth_timestamp' => 1202956957,
	'oauth_consumer_key' => $key,
	'oauth_signature_method' => 'plaintext',
	'oauth_signature' => $secret,
	'oauth_version' => '1.0',
	'xoauth_lang_pref' => 'en-us',
	'oauth_callback' => 'http://google.com');

try
{
	// Obtain a request object for the request we want to make
	$request = new OAuthRequester($url, $method, $params);

	// Sign the request, perform a curl request and return the results, 
	// throws OAuthException2 exception on an error
	// $result is an array of the form: array ('code'=>int, 'headers'=>array(), 'body'=>string)
	$result = $request->doRequest();
	
	$response = $result['body'];
	var_dump($response);
}
catch(OAuthException2 $e)
{
	echo "Exception: " . $e;
}

?>
