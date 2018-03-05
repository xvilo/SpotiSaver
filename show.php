<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SpotiSaver</title>
        <link rel="stylesheet" href="assets/css/app.css">
        <link rel="stylesheet" href="https://use.typekit.net/lbn2fut.css">
        <link rel="preconnect" href="https://code.jquery.com" crossorigin>
        <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    </head>
    <body>
	    <div class="progress-bar-container">
		    <div style="width:0%;" class="js-progress progress-bar"></div>
	    </div>
	    <div class="js-total-time total-time"></div>
	    <div class="js-current-time current-time"></div>
        <div class="js-spotify-container spotify-content hidden">
            <h1 class="js-main-title main-title"></h1>
            <div class="album-art-container">
                <svg xmlns="http://www.w3.org/2000/svg" class="svg-pictogram svg-pictogram--pause" viewBox="0 0 271.95 271.95"><g><path d="M135.98 271.95c75.1 0 135.97-60.88 135.97-135.97S211.07 0 135.98 0 0 60.88 0 135.98s60.88 135.97 135.98 135.97zm0-250.2c62.98 0 114.22 51.25 114.22 114.23S198.96 250.2 135.98 250.2 21.76 198.96 21.76 135.98 72.99 21.76 135.98 21.76z"/><path d="M110.7 200.11a13.6 13.6 0 0 0 13.6-13.6V83.18a13.6 13.6 0 1 0-27.2 0v103.35a13.6 13.6 0 0 0 13.6 13.6zM165.1 200.11a13.6 13.6 0 0 0 13.6-13.6V83.18a13.6 13.6 0 1 0-27.2 0v103.35a13.6 13.6 0 0 0 13.6 13.6z"/></g></svg>
                <img class="js-album-art album-art">
            </div>
            <h2 class="js-song-title song-title"></h2>
            <h3 class="js-song-artist song-artist"></h3>
        </div>
        <div id="bg">
            <img class="js-background-img">
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
    <script>
        var supportsES6 = function() {
            try {
                new Function("(a = 0) => a");
                return true;
            }
            catch (err) {
                return false;
            }
        }();

        console.log("using: ", supportsES6 ? 'ES6' : 'ES5');

        var script = document.createElement("script");
        script.src = supportsES6 ? 'assets/js/app.js' : 'assets/js/app-es5.js';
        document.head.appendChild(script);

        window.spotifyApi = {};
        spotifyApi.token = '<?php echo $_GET['token'] ?>';
        spotifyApi.hideTitle = <?php echo isset($_GET['hideTitle']) ? 'true' : 'false' ?>;
    </script>
</html>