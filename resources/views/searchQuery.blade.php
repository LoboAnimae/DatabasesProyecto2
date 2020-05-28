<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
</head>
<style>
    body {
        overflow: hidden;
    }

    .tableContainer {
        width: 100%;
        display: inline-grid;
        grid-template-columns: auto auto auto;
        grid-template-rows: 50% 50% 50%;
        overflow: hidden;
        grid-column-gap: 1em;
        height: 1428px;
        top: 25px;
        position: relative;

    }
    .searcher {
        text-align: center;
    }

    #searchBox {
        width: 75%;
        height: 50px;
    }

    label {
        font-size: 25px;
    }

    #submit {
        border-radius: 13px;
        width: 75%;
        height: 44px;
        background: white;
        position: relative;
        box-shadow: 10px 10px 60px #aaa;
        top: 13px;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    #goBack {
        position: absolute;
        right: 29px;
        top: 24px;
        width: 147px;
        height: 58px;
        background: white;
        border-radius: 34px;
    }

</style>

<body>

<div class="mainContainer">

    <h1 style="text-align: left">Welcome to the search section!</h1>
    <button id="goBack">Go Back</button>
    <label style="text-align: left">Your search:</label><br>
    <div class="searcher">
        <input type="text" id="searchBox"><br>
        <input type="button" id="submit" value="Search!"/>

    </div>
<div class="tableContainer" style="height: ">
    <div class="tableContainerArtist" style="overflow: auto">
        <h3>Artists</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Artist</th>
            </tr>
            @foreach($artists as $artistsTable)
                <tr>
                    <td>
                        {{$artistsTable->artistid}}
                    </td>
                    <td>
                        {{$artistsTable->name}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>

    <div class="tableContainerAlbums" style="overflow: auto">
        <h3>Albums</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Album Title</th>
                <th>Artist</th>

            </tr>
            @foreach($albums as $albumTable)
                <tr>
                    <td>
                        {{$albumTable->id}}
                    </td>
                    <td>
                        {{$albumTable->title}}
                    </td>
                    <td>
                        {{$albumTable->artist}}
                    </td>
                </tr>


            @endforeach
        </table>

    </div>
    <div class="tableContainerTracks" style="overflow: auto">
        <h3>Tracks</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Track Title</th>
                <th>Album</th>
                <th>Artist</th>
                <th>Media Type</th>
                <th>Genre</th>
                <th>Composer</th>
                <th>Duration</th>
                <th>File Size</th>
                <th>Unit Size</th>


            </tr>
            @foreach($tracks as $trackTable)
                <tr>
                    <td>
                        {{$trackTable->trackid}}
                    </td>
                      <td>
                        {{$trackTable->track}}
                    </td>
                      <td>
                        {{$trackTable->album}}
                    </td>
                      <td>
                        {{$trackTable->artist}}
                    </td>
                      <td>
                        {{$trackTable->media}}
                    </td>
                      <td>
                        {{$trackTable->genre}}
                    </td>
                      <td>
                        {{$trackTable->composer}}
                    </td>
                      <td>
                        {{$trackTable->duration}}
                    </td>
                      <td>
                        {{$trackTable->size}}
                    </td>
                    <td>
                        {{$trackTable->price}}
                    </td>

                </tr>


            @endforeach
        </table>

    </div>
</div>
</div>

</body>
<script>

    const searchButton = document.getElementById('submit');
    const textBox = document.getElementById('searchBox');
    searchButton.addEventListener('click', function () {
        if (textBox.value != '') {
            searchQuery = textBox.value;
            code = 0;
            url = 'http://projectobases.test/searchQuery/';
            searchQuery = searchQuery.replace(/\//g, '|');
            searchQuery = encodeURI(searchQuery);
            window.location.href = `${url}${code}/${searchQuery}`
        } else {
            window.location.href = 'http://projectobases.test/searchQuery'
        }
    })

    const goBack = document.getElementById('goBack')
    goBack.addEventListener('click', function () {
        window.location.href = 'http://projectobases.test/profile'
    })


</script>
</html>
