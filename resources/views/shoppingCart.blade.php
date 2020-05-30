<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Shopping Cart</title>

    <style>
        html, body, .shoppingCartContainer {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }

        .title {
            width: 100%;
            height: 100px;
            background-color: #3b3a3b;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: xx-large;
        }

        #textContainer {
            padding-left: 20px;
        }

        #goBackButton {
            border-radius: 10px;
            background-color: #3b3a3b;
            border: 3px solid white;
            padding: 20px;
            color: white;
            font-size: 0.90em;
        }

        #goBackButton:hover {
            background-color: #fff;
            color: #3b3a3b;
        }

        #yourItems {
            width: 100%;
            height: fit-content;
            background-color: #ddd;
            font-size: xx-large;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #textContainerItems {
            text-align: center;
            height: 100%;
            background-color: #fff;
            padding: 0 40px 0 40px;
        }

        .shoppingCartContainer {
            width: 100%;
            height: fit-content;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

        }

        #shoppingCartTable {
            margin-top: 30px;
            width: 75%;
        }

    </style>
</head>
<body>

<div class="title">
    <div id="textContainer">Your Shopping Cart</div>
    <button id="goBackButton">Go Back</button>
</div>
<div class="shoppingCartContainer">
    <div id="yourItems">
        <div id="textContainerItems">Your Items</div>
    </div>
    <div id="shoppingCartTable">
        <table>
            <tr>
                <th>Artist</th>
                <th>Album</th>
                <th>Track</th>
            </tr>
            @foreach($mongoUser as $mongoUserTable)
                <tr>
                    <td style="width: 30%; text-align: center">{{ $mongoUserTable->artist }}</td>
                    <td style="width: 30%; text-align: center">{{ $mongoUserTable->album }}</td>
                    <td style="width: 40%; text-align: center">{{ $mongoUserTable->track }}</td>

                    <form action="{{action('HomeController@deleteFromShoppingCart')}}" method="POST">
                        @csrf
                        <td>
                            <button name="trackid" value="{{ $mongoUserTable->trackid }}">Delete</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </table>
    </div>
</div>

</body>
</html>
