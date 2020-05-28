<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statistics</title>

    <style>

        h1 {

        }
        .mainContainer {
            height: 100%;
            width: 100%;
            display: inline-grid;
            grid-template-columns: 25% 25% 25% 25%;
            grid-template-rows: 40% 40% 40% 40%;
            overflow: hidden;

        }

        .top5 {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .top5songs {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .playlistDuration {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .longestSongs {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .usersWithMostSongs {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .avgPerGenre {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .quantityPerPlaylist {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
        }

        .genreDiversity {
            border-radius: 23px;
            border: 1px solid;
            height: fit-content;
            width: fit-content;
            overflow: auto;
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
    </style>
</head>
<body>
<h1>Some statistics</h1>
<div class="mainContainer">
    <div class="top5">
        <h3>Top 5 Artists with the most albums published!</h3>
        <table>
            <tr>
                <th>Artist</th>
                <th>Albums Published</th>
            </tr>
            @foreach($top5Artists as $top)
                <tr>
                    <td>
                        {{$top->name}}
                    </td>
                    <td>
                        {{$top->albums}}
                    </td>
                </tr>


            @endforeach
        </table>

    </div>
    <div class="top5songs">
        <h3>Top 5 Genres with the most Songs published!</h3>
        <table>
            <tr>
                <th>Genre</th>
                <th>Genre's Published</th>
            </tr>
            @foreach($genreMostSongs as $mostSongs)
                <tr>
                    <td>
                        {{$mostSongs->name}}
                    </td>
                    <td>
                        {{$mostSongs->counter}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="playlistDuration">
        <h3>Playlist Duration</h3>
        <table>
            <tr>
                <th>Playlist</th>
                <th>Duration</th>
            </tr>
            @foreach($playlistDuration as $durationTable)
                <tr>
                    <td>
                        {{$durationTable->name}}
                    </td>
                    <td>
                        {{$durationTable->duration}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="longestSongs">
        <h3>Longest Songs Duration</h3>
        <table>
            <tr>
                <th>Song</th>
                <th>Duration</th>
            </tr>
            @foreach($longestSongs as $songTable)
                <tr>
                    <td>
                        {{$songTable->name}}
                    </td>
                    <td>
                        {{$songTable->duration}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="usersWithMostSongs">
        <h3>Users with the most submitted songs</h3>
        <table>
            <tr>
                <th>User</th>
                <th>Number of Submitted Songs</th>
            </tr>
            @foreach($userSubmitted as $submittedTable)
                <tr>
                    <td>
                        {{$submittedTable->name}}
                    </td>
                    <td>
                        {{$submittedTable->submitted}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="avgPerGenre">
        <h3>Average of Song Duration per Genre</h3>
        <table>
            <tr>
                <th>Genre</th>
                <th>Song Average</th>
            </tr>
            @foreach($avgGenre as $avgTable)
                <tr>
                    <td>
                        {{$avgTable->name}}
                    </td>
                    <td>
                        {{$avgTable->average}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="quantityPerPlaylist">
        <h3>Quantity of Artists per Genre</h3>
        <table>
            <tr>
                <th>Genre</th>
                <th>Artist Frequency</th>
            </tr>
            @foreach($artistPerPlaylist as $playlistTable)
                <tr>
                    <td>
                        {{$playlistTable->name}}
                    </td>
                    <td>
                        {{$playlistTable->counter}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
    <div class="genreDiversity">
        <h3>Top 5 Artists with the Most Album Diversity Published!</h3>
        <table>
            <tr>
                <th>Artist</th>
                <th>Albums with Different Genres</th>
            </tr>
            @foreach($genreDiversity as $divTable)
                <tr>
                    <td>
                        {{$divTable->name}}
                    </td>
                    <td>
                        {{$divTable->counter}}
                    </td>
                </tr>


            @endforeach
        </table>
    </div>
</div>
</body>
</html>
