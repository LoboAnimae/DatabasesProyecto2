<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('PageTitle')</title>

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
            left: 200px;
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



        @yield('style')


    </style>
</head>
<body>

<nav class="header">
    @yield('PageTitle')
    <div class="goToProfile" id="goBackButton">
        <p1 style="margin: 0px; position: relative;left: -17px;top: 16px;">Go Back</p1>
    </div>
</nav>
@yield('Content')

<div class="registrationInformation" id="informationContainer">

</div>

@yield('JavaScript')

</body>
</html>
