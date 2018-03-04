<?php
	
	require './vendor/autoload.php';
	require './src/functions.php';
    require './config.php';

    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $session = new SpotifyWebAPI\Session(
        $config['spotify']['client_id'],
        $config['spotify']['client_secret'],
        $config['baseUrl'] . 'callback.php');
	
	$data = json_decode(file_get_contents('data/' . $_GET['token'] . ".dat")) or die(json_encode(array_merge(['internal_status' => false])));

	$accessToken = $data->accessToken;
	$refresh = $data->refreshToken;
	
	$session->refreshAccessToken($refresh);
	$accessToken = $session->getAccessToken();
	$api->setAccessToken($accessToken);

	if(isset($_POST['playlistUri'])) {
        preg_match ( '/user:(.*):playlist:(.*)/' , $_POST['playlistUri'], $matches);

        $userId = $matches[1];
        $playlistId = $matches[2];

        $apiData = ['playlist_data' => json_decode(
            json_encode($api->getUserPlaylist($userId, $playlistId)),
            true
        )];

        die(json_encode(array_merge(['internal_status' => true], $apiData)));
    }

	$apiData = array_merge(
        ['current_track' => json_decode(
            json_encode($api->getMyCurrentTrack()),
            true
        )],
        ['user_data' => json_decode(
            json_encode($api->me()),
            true
        )],
        ['device_data' => json_decode(
            json_encode($api->getMyDevices()),
            true
        )]
    );

	if($apiData === null) {
        echo json_encode(array_merge(['internal_status' => false]));
        die();
    }

	echo json_encode(array_merge(['internal_status' => true], $apiData));