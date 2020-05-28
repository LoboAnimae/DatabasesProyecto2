<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>

    <style>
        body {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        .header {
            height: 100px;
            line-height: 96px;
            background: #70869e;
            color: white;
            font-family: times new roman, sans-serif;
            text-decoration: underline;
            font-size: 62px;
            position: relative;
            width: -webkit-fill-available;
            text-indent: 34px;
            border: 1px solid;
            padding: 10px;
            box-shadow: 5px 10px 8px #888888;
        }

        h3 {
            font-size: 34px;
            font-family: Times New Roman, sans-serif;
            color: white;
            background: #70869e;
            width: 50%;
            position: relative;
            left: 196px;
            border: 0px solid;
            padding: 10px;
            box-shadow: 5px 10px 8px #888888;
        }

        textarea {
            position: relative;
            left: 500px;
            resize: none;
            width: 375px;
            height: 39px;
            border-radius: 58px;
            line-height: 38px;
            top: -44px;
            padding: 10px;
            box-shadow: 5px 10px 8px #888888;
        }

        input#submit {
            margin: 0px;
            background: #70869e;
            color: white;
            width: 224px;
            position: relative;
            right: -891px;
            height: 59px;
            font-size: 39px;
            top: 45px;
            font-family: times new roman, sans-serif;
            border: 0px solid;
            padding: 10px;
            box-shadow: 5px 10px 8px #888888;

        }


        #registrationCategory {
            margin: 16px;
            border: 0px;
            font-size: xx-large;
            position: relative;
            text-align: center;
            left: 18%;
        }

        .MainContainer {
            position: relative;

            font-size: 54px;
            top: 19px;
        }

        #informationContainer {
            font-size: xx-large;
        }

        .goToProfile {
            color: white;
            text-indent: 34px;
            top: 0px;
            margin: 0;
            padding: 0;
            width: fit-content;
            position: absolute;
            line-height: 69px;
            font-size: 26px;
            font-family: Times New Roman, sans-serif;
            right: 0;
            text-align: center;
            height: 120px;
            background: #70869e;
        }


    </style>
</head>
<body>

<nav class="header">
    Update Form
    <div class="goToProfile" id="goBackButton">
        <p1 style="margin: 0px; position: relative;left: -17px;top: 16px;">Go Back</p1>
    </div>
</nav>


<div class="MainContainer">
    <label for="registrationCategory">What are you going to update?</label><br>

    <select name="select_category" id="registrationCategory" onchange="changeHTML()">
        <option value="empty">Select a Value</option>
        <option value="artist">Artist</option>
        <option value="album">Album</option>
        <option value="cancion">Track</option>
        <br>
    </select>
    <input id="submit" type="submit" name="button" value="Submit" style="display: none;"/>
    <!--        <button id='submit' style="display: none">Submit</button><br>-->


</div>

<div class="registrationInformation" id="informationContainer">

</div>

</body>
<script>
    const selector = document.getElementById('registrationCategory');


    const informationContainer = document.getElementById('informationContainer');

    function changeHTML() {
        if (selector.value == 'empty') {
            document.getElementById('submit').style.display = "none";
            informationContainer.innerHTML = '';
            informationContainer.innerHTML = '<p1>Please select an option</p1>'
        } else if (selector.value == 'artist') {
            document.getElementById('submit').style.display = 'inline';
            informationContainer.innerHTML = '';
            informationContainer.innerHTML = "<h3>Artist Name</h3><br><textarea id=\"artistName\" placeholder=\"The name of your artist...\"></textarea><br><br><textarea id=\"newArtistName\" placeholder=\"The replacement name...\"></textarea>";
            currentButton = document.getElementById('submit');
            currentButton.addEventListener('click', function () {
                if (document.getElementById('artistName').value == '' && document.getElementById('newArtistName').value != '') {
                    alert("Artist name can't be empty!")
                } else {
                    alert("Your changes have been submitted");
                    artist_name = document.getElementById('artistName').value;
                    artist_name = artist_name.replace(/\//g, '|');
                    new_artist_name = document.getElementById('newArtistName').value;
                    new_artist_name = new_artist_name.replace(/\//g, '|');
                    url = 'http://projectobases.test/updateInfoArtist/';                                                                       // GENERATE LINK HERE
                    artistFormated = encodeURIComponent(artist_name);
                    newArtistFormatted = encodeURIComponent(new_artist_name);

                    window.location.href = `${url}${artistFormated}/${newArtistFormatted}`


                }
            })
        } else if (selector.value == 'album') {
            document.getElementById('submit').style.display = 'inline';
            informationContainer.innerHTML = '';
            informationContainer.innerHTML = '<h3>Artist Name</h3><br><textarea id="artistName" placeholder="The name of your artist..."></textarea><br><h3>Album Name</h3><br><textarea id="albumName" placeholder="The name of your album..."></textarea><br><textarea id=\"newAlbumName\" placeholder=\"The replacement name...\"></textarea>';
            currentButton = document.getElementById('submit');

            currentButton.addEventListener('click', function () {
                if (document.getElementById('artistName').value == '') {
                    alert("Artist name can't be empty!")
                }
                if (document.getElementById('albumName').value == '') {
                    alert("Album name can't be empty!")
                }
                if (document.getElementById('newAlbumName').value == '') {
                    alert("New album name can't be empty!")
                }

                if (document.getElementById('artistName').value != '' && document.getElementById('albumName').value != '' && document.getElementById('newAlbumName').value != '') {
                    alert("Your changes have been submitted");
                    artist_name = document.getElementById('artistName').value;
                    album_name = document.getElementById('albumName').value;
                    new_album_name = document.getElementById('newAlbumName').value;

                    url = 'http://projectobases.test/updateInfoAlbum/';

                    artist_name = artist_name.replace(/\//g, '|');
                    album_name = album_name.replace(/\//g, '|');
                    new_album_name = new_album_name.replace(/\//g, '|');

                    artistFormated = encodeURIComponent(artist_name);
                    albumFormated = encodeURIComponent(album_name);
                    newAlbumFormatted = encodeURIComponent(new_album_name);

                    window.location.href = `${url}${artistFormated}/${albumFormated}/${newAlbumFormatted}`
                }
            })
        } else if (selector.value == 'cancion') {
            document.getElementById('submit').style.display = 'inline';
            informationContainer.innerHTML = '';
            informationContainer.innerHTML = '<h3>Artist Name</h3><br><textarea id="artistName" placeholder="The name of your artist..."></textarea><br><h3>Album Name</h3><br><textarea id="albumName" placeholder="The name of your album..."></textarea><br><h3>Track Name and Genre</h3><br><textarea id="trackName" placeholder="The name of your track..."></textarea><br><textarea id="newTrackName" placeholder="The new name of your track..."></textarea><br><br>';
            currentButton = document.getElementById('submit');

            currentButton.addEventListener('click', function () {
                if (document.getElementById('artistName').value == '') {
                    alert("Artist name can't be empty!")
                }
                else if (document.getElementById('albumName').value == '') {
                    alert("Album name can't be empty!")
                }
                else if (document.getElementById('trackName').value == '') {
                    alert("Track name can't be empty!")
                }
                else if (document.getElementById('newTrackName').value == '') {
                    alert("The new Track name can't be empty!")
                }

                else// (document.getElementById('artistName').value != '' && document.getElementById('albumName').value != '' && document.getElementById('trackName').value != '' && document.getElementById('newTrackName'.value != ''))
                     {
                    console.log('Entered');
                    artist_name = document.getElementById('artistName').value;
                    album_name = document.getElementById('albumName').value;
                    track_name = document.getElementById('trackName').value;
                    newTrackName = document.getElementById('newTrackName').value;

                    url = 'http://projectobases.test/updateInfoTrack/';
                    artist_name = artist_name.replace(/\//g, '|');
                    album_name = album_name.replace(/\//g, '|');
                    track_name = track_name.replace(/\//g, '|');
                    newTrackName = newTrackName.replace(/\//g, '|');

                    artistFormated = encodeURIComponent(artist_name);
                    albumFormated = encodeURIComponent(album_name);
                    trackFormated = encodeURIComponent(track_name);
                    newTrackFormatted = encodeURIComponent(newTrackName);

                    window.location.href = `${url}${artistFormated}/${albumFormated}/${trackFormated}/${newTrackFormatted}`

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
</html>
