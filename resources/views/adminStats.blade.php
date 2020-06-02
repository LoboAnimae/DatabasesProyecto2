<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Stats</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        #navBar {
            width: 100vw;
            height: 100px;
            background-color: #3b3a3b;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pageContainer {
            width: 100vw;
            height: 100vh;
        }

        #goBackButton {
            padding: 12px;
            border: 3px solid white;
            border-radius: 10px;
            font-size: x-large;
            cursor: pointer;
        }

        #title {
            padding: 12px;
            font-size: xxx-large;
        }

        #title, #goBackButton {
            margin: 20px;
        }

        #selector {
            height: 30vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #contentContainer {
            height: 20vh;
            width: 100vw;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        #tableContainer {
            width: 100%;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #downloadContainer {
            margin-top: 30px;
            width: fit-content;
            display: flex;
            border: 5px solid #3b3a3b;
            justify-content: flex-end;
            align-items: flex-end;
            position: fixed;
            left: 0;
        }

        #downloadButton {
            width: 100%;
        }

        th, td {
            text-align: center;
            margin: 10px;

        }

    </style>
</head>
<body>
<div class="pageContainer">
    <div id="navBar">
        <div id="title">Admin Statistics</div>
        <div id="goBackButton">Go back</div>
    </div>
    <form action="{{ action('HomeController@displayAdminContent') }}" METHOD="POST">
        @csrf
        <div id="selector">
            <select name="select_category" id="queue_category" onchange="showContent()">
                <option value="total_sales">Total Sales Between Two Dates</option>
                <option value="artists_number">Artists With the Most Sales</option>
                <option value="genre_total">Genres With the Most Sales</option>
                <option value="tracks_by_artist">Most Reproduced Tracks by Artist</option>
            </select>
        </div>


        <div id="contentContainer">
            <div id="firstDateContainer">
                <label for="firstDate">The First Date: </label>
                <input name="fd" type="text" placeholder="YYYY-MM-DD" id="firstDate">
            </div>
            <div id="secondDateContainer">
                <label for="secondDate">The Second Date: </label>
                <input name="sd" type="text" placeholder="YYYY-MM-DD" id="secondDate">
            </div>
        </div>
        <input type="submit" id="submit" value="Submit" style="position: absolute; width: 100vw">
    </form>
    @if($data_type == 0)
        <div> Select a Query</div>
    @endif
    <div id="downloadContainer">
        <form action="{{ action('HomeController@generateCSVAdmins') }}" METHOD="POST">
            @csrf
            {{-- Total Sales --}}

            @if($data_type == 1)
                <button name="download" value="1" id="downloadButton" type="submit">DownloadCSV</button>
                <input name="firstDate" type="text" style="display: none" value={{$dateOne}}>
                <input name="secondDate" type="text" style="display: none" value={{$dateTwo}}>
            @endif
            {{-- By Artist --}}
            @if($data_type == 2)
                <button name="download" value="2" id="downloadButton" type="submit">DownloadCSV</button>
                <input name="firstDate" type="text" style="display: none" value={{$dateOne}}>
                <input name="secondDate" type="text" style="display: none" value={{$dateTwo}}>
                <input name="limiter" type="text" style="display: none" value={{$limiter}}>
            @endif
            {{-- By Genre --}}
            @if($data_type == 3)
                <button name="download" value="3" id="downloadButton" type="submit">DownloadCSV</button>
                <input name="firstDate" type="text" style="display: none" value={{$dateOne}}>
                <input name="secondDate" type="text" style="display: none" value={{$dateTwo}}>
            @endif
            {{-- By Singular Artists --}}
            @if($data_type == 4)
                <button name="download" value="4" id="downloadButton" type="submit">DownloadCSV</button>
                <input name="artist" type="text" style="display: none" value={{$artistName}}>
                <input name="limiter" type="text" style="display: none" value={{$limiter}}>
            @endif
            @if($data_type == 0)
                <button name="download" value="0" id="downloadButton" type="submit">DownloadCSV</button>

            @endif
        </form>
    </div>
    <div id="tableContainer">


        <table>
            @if($data_type == 1)
                <tr>
                    <th>
                        Year
                    </th>
                    <th>
                        Month
                    </th>
                    <th>
                        Week
                    </th>
                    <th>Total Sales</th>
                </tr>
                @foreach($find_sales as $sale)
                    <tr>
                        <td>{{ $sale->year_number }}</td>
                        <td>{{ $sale->month_number }}</td>
                        <td>{{ $sale->week_number }}</td>
                        <td>${{ $sale->total_sales }}</td>
                    </tr>
                @endforeach
            @endif

            @if($data_type == 2)
                <tr>
                    <th>Artist ID</th>
                    <th>Artist Name</th>
                    <th>Total Sales</th>
                </tr>

                @foreach($find_artist as $artist)
                    <tr>
                        <td>{{ $artist->id }}</td>
                        <td>{{ $artist->artist_name }}</td>
                        <td>${{ $artist->total_sales }}</td>
                    </tr>
                @endforeach
            @endif

            @if($data_type == 3)
                <tr>
                    <th>Genre Name</th>
                    <th>Total Sales</th>
                </tr>

                @foreach($find_genre as $genre)
                    <tr>
                        <td>{{ $genre->genre_name }}</td>
                        <td>${{ $genre->total_sales }}</td>
                    </tr>
                @endforeach
            @endif
            @if($data_type == 4)
                <tr>
                    <th>Album Title</th>
                    <th>Track Title</th>
                    <th>Times Reproduced</th>
                </tr>

                @foreach($queue_artist as $artist)
                    <tr>
                        <td>{{ $artist->album_title }}</td>
                        <td>{{ $artist->track_title }}</td>
                        <td>{{ $artist->reproduced }}</td>
                    </tr>
                @endforeach
            @endif

        </table>
    </div>
</div>

<script>
    function showContent() {
        const selected = document.getElementById('queue_category').value

        if (selected === 'total_sales' || selected === 'genre_total') {
            if (selected === 'total_sales') {
                document.getElementById('downloadButton').value = 1
            } else if (selected === 'genre_total') {
                document.getElementById('downloadButton').value = 3
            }
            const content_container = document.getElementById('contentContainer')
            content_container.innerHTML = "<div id=\"firstDateContainer\">\n" +
                "                <label for=\"firstDate\">The First Date: </label>\n" +
                "                <input name=\"fd\" type=\"text\" placeholder=\"YYYY-MM-DD\" id=\"firstDate\">\n" +
                "            </div>\n" +
                "            <div id=\"secondDateContainer\">\n" +
                "                <label for=\"secondDate\">The Second Date: </label>\n" +
                "                <input name=\"sd\" type=\"text\" placeholder=\"YYYY-MM-DD\" id=\"secondDate\">\n" +
                "            </div>"

        } else if (selected === 'artists_number') {
            document.getElementById('downloadButton').value = 2
            const content_container = document.getElementById('contentContainer')
            content_container.innerHTML = "<div id=\"firstDateContainer\">\n" +
                "                <label for=\"firstDate\">The First Date: </label>\n" +
                "                <input name=\"fd\" type=\"text\" placeholder=\"YYYY-MM-DD\" id=\"firstDate\">\n" +
                "            </div>\n" +
                "            <div id=\"secondDateContainer\">\n" +
                "                <label for=\"secondDate\">The Second Date: </label>\n" +
                "                <input name=\"sd\" type=\"text\" placeholder=\"YYYY-MM-DD\" id=\"secondDate\">\n" +
                "            </div>\n" +
                "            <div id=\"limiter\">\n" +
                "                <label for=\"limiter\">How Many Values: </label>\n" +
                "                <input name=\"limiter\" type=\"text\" placeholder=\"Amount\" id=\"limiter\">\n" +
                "            </div>"
        } else if (selected === 'tracks_by_artist') {
            document.getElementById('downloadButton').value = 4
            const content_container = document.getElementById('contentContainer')
            content_container.innerHTML = "<div id=\"firstDataContainer\">\n" +
                "                <label for=\"firstDate\">Artist Name: </label>\n" +
                "                <input name=\"fd\" type=\"text\" placeholder=\"Name...\" id=\"firstDate\">\n" +
                "            </div>\n" +
                "            <div id=\"secondDateContainer\">\n" +
                "                <label for=\"secondDate\">How Many: </label>\n" +
                "                <input name=\"sd\" type=\"text\" placeholder=\"Number...\" id=\"secondDate\">\n" +
                "            </div>"
        }
    }

    document.getElementById('goBackButton').addEventListener('click', () => {
        window.location = '/profile'
    })
</script>
</body>
</html>
