<?php 
session_start();
include 'lib/EpiCurl.php';
include 'lib/EpiOAuth.php';
include 'lib/EpiTwitter.php';
include 'lib/secret.php';
$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
$oauth_token = $_GET['oauth_token'];
if($oauth_token == '')
  { 
	$url = $twitterObj->getAuthorizationUrl();
  }
$smarty->assign('url', $url);
?> 