<?php
define('MAGENTO_ROOT', dirname(__FILE__));
$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
require_once $mageFilename;

umask(0);

if ( empty($_GET['store']) ) {
	$_GET['store'] = '';
}
Mage::app( $_GET['store'] );

require_once("app/code/community/Solwin/Social/classes/twitteroauth.php"); //Path to twitteroauth library

$twitteruser = Mage::getStoreConfig('socialsettings/twitter/twitter_account');
$notweets = Mage::getStoreConfig('socialsettings/twitter/no_of_tweets');
$consumerkey = Mage::getStoreConfig('socialsettings/twitter/consumer_key');
$consumersecret = Mage::getStoreConfig('socialsettings/twitter/secret_key');
$accesstoken = Mage::getStoreConfig('socialsettings/twitter/access_token');
$accesstokensecret = Mage::getStoreConfig('socialsettings/twitter/access_token_secret');
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
  
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

header('Content-Type: application/json');
echo json_encode($tweets);