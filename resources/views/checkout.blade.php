<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    <style>
        #positionalDiv {
            position: fixed;
            bottom: 0;
            width: 100vw;
            height: fit-content;
            background-color: #3b3a3b;
            color: white;
            font-size: xx-large;
        }

        .buttonConf {
            width: 100%;
            background-color: #3b3a3b;
            color: white;
            height: 100px;
            border: 3px solid white;
            border-radius: 10px;
        }

        .buttonConf:hover {
            background-color: white;
            color: #3b3a3b;

        }

        html, body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            font-size: xx-large;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<div style="display: none;">{{ $sum = 0.0 }}</div>
<div class="contentContainer">
    <div id="items">
        <table>
            <tr>
                <th>Artist</th>
                <th>Album</th>
                <th>Track</th>
            </tr>
            @foreach($mongoUser as $track)
                <tr>
                    <td>{{ $track->artist }}</td>
                    <td> {{ $track->album }}</td>
                    <td> {{ $track->track }}</td>
                    <td> {{ $track->price }}</td>
                    <div style="display: none">{{ $sum += (float)($track->price) }}</div>
                </tr>
            @endforeach
        </table>

    </div>
    <div id="positionalDiv">
        <div id="total"><b>Your Total: </b>${{$sum}}</div>
        <button class="buttonConf" id="buyAll">Buy All!</button>
        <button class="buttonConf" id="goBack">Go Back</button>
    </div>
</div>

<script>
    document.getElementById('buyAll').addEventListener('click', () => {
        const confirmation = confirm('Are you sure you want to buy all? Your total will come out to be ${{$sum}}!')
        if (confirmation) {
            window.location = '/confirmBuyAll'
        }
    })
    document.getElementById('goBack').addEventListener('click', () => {
        window.location = '/shoppingCart'
    })

</script>
</body>
</html>
