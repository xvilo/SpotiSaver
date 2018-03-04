<?php
	require './vendor/autoload.php';
	require './src/functions.php';
    require './config.php';

    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $session = new SpotifyWebAPI\Session(
       $config['spotify']['client_id'],
       $config['spotify']['client_secret'],
       $config['baseUrl'] . 'callback.php');

	try {
        // Get the authorization URL and send the user there
        header('Location: '.$session->getAuthorizeUrl(array(
                    'scope' => array(
                        'user-read-email',
                        'user-read-private',
                        'user-read-recently-played',
                        'user-read-playback-state',
                        'user-modify-playback-state',
                        'user-read-currently-playing'),
                    'show_dialog' => true, )));
	} catch (SpotifyWebAPI\SpotifyWebAPIException $e) {
	    echo 'There was an error during the authentication flow (exception '.$e.')';
	    return '';
    }
