<?php
session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

//Google API PHP Library includes
require_once 'vendor/autoload.php';

// Set config params to access Google API
$client_id = $_ENV["CLIENT_ID"];
$client_secret = $_ENV["CLIENT_SECRET"];
$redirect_uri = $_ENV["BASE_URL"].'/index.php';

//Create and Request to access Google API
$client = new Google_Client();
$client->setApplicationName("Google OAuth Login With PHP");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('https://mail.google.com/');

$objRes = new Google_Service_Oauth2($client);

//Add access token to php session after successfully authenticate
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

//set token
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
}

//store with user data
if ($client->getAccessToken()) {
    $userData = $objRes->userinfo->get();
    if (!empty($userData)) {
        //insert data into database
    }
    $_SESSION['access_token'] = $client->getAccessToken();
} else {
    $googleAuthUrl = $client->createAuthUrl();
}

//logout from web application
if (isset($_REQUEST['logout'])) {
    unset($_SESSION['access_token']);
    $client->revokeToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
}