@extends('sub_main')

@section('PageTitle')
Delete Page
@endsection

@section('style')
#deletionCategory {
margin: 16px;
border: 0px;
font-size: xx-large;
position: relative;
text-align: center;
left: 18%;
}
@endsection

@section('Content')


<div class="MainContainer">
    <label for="deletionCategory">What do you wish to Delete?</label><br>


    <form action="{{ action('HomeController@deleteSomething') }}" method="POST">
        <select name="select_category" id="deletionCategory" onchange="changeHTML()">
            <option value="empty">Select a Value</option>
            <option value="artist">Artist</option>
            <option value="album">Album</option>
            <option value="cancion">Track</option>
            <br>
        </select>
        <input id="submit" type="submit" name="button" value="Submit" style="display: none;" />


</div>

<div class="registrationInformation" id="informationContainer">

</div>
</form>
@endsection


@section('JavaScript')
<script>
    const selector = document.getElementById('deletionCategory');


        const informationContainer = document.getElementById('informationContainer');

        function changeHTML() {
            if (selector.value == 'empty') {
                document.getElementById('submit').style.display = "none";
                informationContainer.innerHTML = '';
                informationContainer.innerHTML = '<p1>Please select an option</p1>'
            } else if (selector.value == 'artist') {
                document.getElementById('submit').style.display = 'inline';
                informationContainer.innerHTML = '';
                informationContainer.innerHTML = "<h3>Artist Name</h3><br><input name=\"artist\" id=\"artistName\" placeholder=\"The name of your artist...\"></input><br>";
                currentButton = document.getElementById('submit');
                currentButton.addEventListener('click', function () {
                    if (document.getElementById('artistName').value == '') {
                        alert("Artist name can't be empty!")
                    } else {
                        alert("Your changes have been submitted");
                        artist_name = document.getElementById('artistName').value;
                        artist_name = artist_name.replace(/\//g, '|');
                        url = 'http://projectobases.test/delete/';
                        artistFormated = encodeURIComponent(artist_name);
                        // alert(encodeURIComponent(artist_name))

                        // window.location.href = `${url}${artistFormated}`


                    }
                })
            } else if (selector.value == 'album') {
                document.getElementById('submit').style.display = 'inline';
                informationContainer.innerHTML = '';
                informationContainer.innerHTML = '<h3>Artist Name</h3><br><input name="artist" id="artistName" placeholder="The name of your artist..."></input><br><h3>Album Name</h3><br><input name="album" id="albumName" placeholder="The name of your album..."></input><br>';
                currentButton = document.getElementById('submit');

                currentButton.addEventListener('click', function () {
                    if (document.getElementById('artistName').value == '') {
                        alert("Artist name can't be empty!")
                    }
                    if (document.getElementById('albumName').value == '') {
                        alert("Album name can't be empty!")
                    }

                    if (document.getElementById('artistName').value != '' && document.getElementById('albumName').value != '') {
                        alert("Your changes have been submitted");
                        artist_name = document.getElementById('artistName').value;
                        album_name = document.getElementById('albumName').value;
                        url = 'http://projectobases.test/delete/';
                        artist_name = artist_name.replace(/\//g, '|');
                        album_name = album_name.replace(/\//g, '|');

                        artistFormated = encodeURI(artist_name);
                        albumFormated = encodeURI(album_name);

                        // window.location.href = `${url}${artistFormated}/${albumFormated}`
                    }
                })
            } else if (selector.value == 'cancion') {
                document.getElementById('submit').style.display = 'inline';
                informationContainer.innerHTML = '';
                informationContainer.innerHTML = '<h3>Artist Name</h3><br><input name="artist" id="artistName" placeholder="The name of your artist..."></input><br><h3>Album Name</h3><br><input name="album" id="albumName" placeholder="The name of your album..."></input><br><h3>Track Name and Genre</h3><br><input name="track" id="trackName"placeholder="The name of your track..."></input><br><input name="genre" id="trackGenre"placeholder="The genre of your track..."></input><br><input name="url" id="url"placeholder="Your Track\'s URL"></input><br>';
                currentButton = document.getElementById('submit');

                currentButton.addEventListener('click', function () {
                    if (document.getElementById('artistName').value == '') {
                        alert("Artist name can't be empty!")
                    }
                    if (document.getElementById('albumName').value == '') {
                        alert("Album name can't be empty!")
                    }
                    if (document.getElementById('trackName').value == '') {
                        alert("Track name can't be empty!")
                    }
                    if (document.getElementById('artistName').value != '' && document.getElementById('albumName').value != '' && document.getElementById('trackName').value != '') {


                        // artist_name = document.getElementById('artistName').value;
                        // album_name = document.getElementById('albumName').value;
                        // track_name = document.getElementById('trackName').value;
                        // url = 'http://projectobases.test/delete/';
                        // artist_name = artist_name.replace(/\//g, '|');
                        // album_name = album_name.replace(/\//g, '|');
                        // track_name = track_name.replace(/\//g, '|');
                        // artistFormated = encodeURI(artist_name);
                        // albumFormated = encodeURI(album_name);
                        // trackFormated = encodeURI(track_name);

                        // window.location.href = `${url}${artistFormated}/${albumFormated}/${trackFormated}`
                    }
                })

            }
        }

        const goBackButton = document.getElementById('goBackButton');
        goBackButton.addEventListener("click", function () {
            window.location = 'http://projectobases.test/profile';
        });

        goBackButton.addEventListener('mouseenter', function () {
            goBackButton.style.background = "#7086ff"
        });
        goBackButton.addEventListener('mouseleave', function () {
            goBackButton.style.background = "#70869e"
        })


</script>





@endsection
