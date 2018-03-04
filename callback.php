<?php
	require './vendor/autoload.php';
	require './src/functions.php';
	require './config.php';

	$session = new SpotifyWebAPI\Session(
	    $config['spotify']['client_id'],
        $config['spotify']['client_secret'],
        $config['baseUrl'] . 'callback.php');
	$api = new SpotifyWebAPI\SpotifyWebAPI();
	
	if(isset($_GET['code'])) {
		$ret = $session->requestAccessToken($_GET['code']);
		$accessToken = $session->getAccessToken();
		$refreshToken = $session->getRefreshToken();
		$api->setAccessToken($accessToken);
	    $uri = $api->me()->uri;
	    file_put_contents('data/' . md5($uri) . ".dat", json_encode(['accessToken' => $accessToken, 'refreshToken' => $refreshToken]));
	    header('Location: ' . $config['baseUrl'] . 'show.php?token='.md5($uri));
	} 