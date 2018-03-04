class Spotify {
    constructor(accessToken) {
        this.currData = [];
        this.accessToken = accessToken;
    }

    requestNowPlaying() {
        var that = this;
        $.getJSON("/spotify.php?token=" + this.accessToken, function( data ) {
            data['internal_status'] ? $('.js-spotify-container').removeClass('hidden') : $('.js-spotify-container').addClass('hidden');

            that.setIsPlaying(data['current_track']['is_playing']);
            that.setProgress(data['current_track']['progress_ms'], data['current_track']['item']['duration_ms']);
            that.setAlbumArtwork(data['current_track']['item']['album']['images']);
            that.setSongInfo(data['current_track']['item']['name'], data['current_track']['item']['album']['artists'][0]['name']);
            that.setTitle(data['current_track']['context'], data['user_data']['id']);
        });

        setTimeout(_.bind(this.requestNowPlaying, this), 1000);
    }

    setIsPlaying(state) {
        if(this.currData.isPlaying == state)
            return true;
        this.currData.isPlaying = state;

        if(state) {
            $(".js-spotify-container").addClass("playing");
            $(".js-spotify-container").removeClass("stopped");
        } else {
            $(".js-spotify-container").addClass("stopped");
            $(".js-spotify-container").removeClass("playing");
        }
    }

    setProgress(current, total) {
        var progress = current / total * 100
        var currentSeconds = this.msToMinutesAndSeconds(current);
        var totalSeconds   = this.msToMinutesAndSeconds(total);

        $('.js-progress').width(progress + "%");
        $('.js-total-time').text(totalSeconds);
        $('.current-time').text(currentSeconds);
    }

    setAlbumArtwork(artworkData) {
        if(this.currData.artworkData == artworkData)
            return true;
        this.currData.artworkData = artworkData;

        $(".js-album-art").attr("src",artworkData[0].url);
        $(".js-background-img").attr("src", artworkData[2].url);
    }

    setSongInfo(trackTitle, artistName) {
        if(this.currData.trackTitle == trackTitle && this.currData.artistName == artistName)
            return true;
        this.currData.trackTitle = trackTitle;
        this.currData.artistName = artistName;

        $( ".js-song-title" ).text(trackTitle);
        $( ".js-song-artist" ).text('By: ' + artistName);
    }

    setTitle(context, userName) {
        if(this.currData.userName == userName)
            return true;

        if(context) {
            _.bind(this.getPlaylistDataFromContext, this, context);
            return true;
        }

        if(!isNaN(userName))
            return false;

        this.currData.userName = userName;

        $( ".js-main-title" ).text("What is " + userName + " listening to?");
    }

    msToMinutesAndSeconds(ms) {
        var minutes = Math.floor(ms / 60000);
        var seconds = ((ms % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }

    getPlaylistDataFromContext(context) {
        $.post( "/spotify.php?token=" + this.accessToken, {playlistUri: context.uri}, function(data) {
            var name = data['playlist_data']['name'];
            var owner = data['playlist_data']['owner']['display_name'];

            $( ".js-main-title" ).text("Playing " + name + " by " + owner);
        }, 'json');
    }
}