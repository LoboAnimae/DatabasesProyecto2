@extends('sub_main')





@section('PageTitle')
    Hide a Song
@endsection




@section('Content')
    <div class="MainContainer">
        <label for="deletionCategory">What do you wish to Hide?</label><br>
        <h3>Artist Name</h3><br>
        <textarea id="artistName" placeholder="The name of your artist..."></textarea><br>
        <h3>Album Name</h3><br><textarea id="albumName" placeholder="The name of your album..."></textarea><br>
        <h3>Track Name and Genre</h3><br><textarea id="trackName" placeholder="The name of your track..."></textarea>


        <input id="submit" type="submit" name="button" value="Submit" style="left: 42%; top: 0px;"/>


    </div>


@endsection




@section('JavaScript')
    <script>
        const artist = document.getElementById('artistName');
        const album = document.getElementById('albumName');
        const track = document.getElementById('trackName');
        const submitButton = document.getElementById('submit');

        submitButton.addEventListener('click', function () {
            if (artist.value != '') {
                if (album.value != '') {
                    if (track.value != '') {
                        artist_name = artist.value;
                        album_name = album.value;
                        track_name = track.value;

                        url = 'http://projectobases.test/hide/';
                        artist_name = artist_name.replace(/\//g, '|');
                        album_name = album_name.replace(/\//g, '|');
                        track_name = track_name.replace(/\//g, '|');

                        artistFormated = encodeURI(artist_name);
                        albumFormated = encodeURI(album_name);
                        trackFormated = encodeURI(track_name);
                        window.location.href = `${url}${artistFormated}/${albumFormated}/${trackFormated}`
                    } else alert('Track name can\'t be empty')
                } else alert('Album name can\'t be empty')
            } else alert('Artist name can\'t me empty')
        })

        const goBackButton = document.getElementById('goBackButton')
        goBackButton.addEventListener("click", function () {
            window.location='http://projectobases.test/profile';
        })

        goBackButton.addEventListener('mouseenter', function(){
            goBackButton.style.background="#7086ff"
        })
        goBackButton.addEventListener('mouseleave', function(){
            goBackButton.style.background="#70869e"
        })


    </script>

@endsection
