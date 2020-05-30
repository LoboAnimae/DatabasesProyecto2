<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Log</title>
    <style>
        html, body {
            margin: 0;
            width: 100%;
            height: 100%;
        }

        .pageContainer {
            height: 100%;
            width: 100%;
        }

        .upperContainer {
            width: 100%;
            height: 100px;
            background-color: #3b3a3b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #title {
            font-size: xxx-large;
            margin: 0 0 0 50px;
            padding: 12px;
        }

        #goBackButton {
            margin: 0 50px 0 0;
            padding: 12px;
            font-size: x-large;
            background-color: #3b3a3b;
            color: white;
            border: 3px solid #3b3a3b;
            border-radius: 10px;
            box-sizing: border-box;

        }

        #goBackButton:hover {
            border: 3px solid white;
            box-sizing: border-box;
        }

        .instructions {
            margin: 50px;
            font-size: x-large;
        }

        .instructions ul {
            font-size: 0.85em;
        }

        table {
            width: 100%;
        }

        th, td {
            text-align: center;
        }

        tr {
            padding: 10px;
            height: 30px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }


    </style>
</head>

<body>
<div class="pageContainer">
    <div class="upperContainer">
        <div id="title">Data ChangeLog</div>
        <div id="goBack">
            <button id="goBackButton" onclick="goBack()">Go Back</button>
        </div>
    </div>
    <div class="instructions">Here you can notice the changes done to the database. Notice that these changes have been
        taken into account because:
        <ul>
            <li>We consider you to be able to search for any discrepancies.</li>
            <li>We know you can use the search tab given the need to do so.</li>
        </ul>
    </div>
    <div class="tableContainer">
        <table>
            <tr>
                <th>Event</th>
                <th>Target</th>
                <th>Done By</th>
                <th>Date</th>
                <th>Modified Code</th>
            </tr>
            @foreach($changes as $tableChanges)

                <tr>
                    <td>{{ $tableChanges->event_name }}</td>

                    <td>
                        {{ $tableChanges->target }}
                    </td>
                    <td>
                        {{ $tableChanges->done_by }}
                    </td>
                    <td>
                        {{ $tableChanges->date_of_event }}
                    </td>
                    <td>
                        {{ $tableChanges->modified }}
                    </td>
                </tr>

            @endforeach
        </table>
    </div>

</div>
<script>
    function goBack() {
        window.location = "/profile"
    }
</script>

</body>

</html>
