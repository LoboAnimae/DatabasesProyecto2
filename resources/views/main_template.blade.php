<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    Load fonts--}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <title>Template</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .circular--portrait {
            position: relative;
            width: 170px;
            height: 170px;
            overflow: hidden;
            border-radius: 100%;
        }

        .Circle {
            width: 200px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            /*background: #4db8ff;*/
            border-radius: 100%;
            position: absolute;
            top: 15px;
        }

        body {
            background: none;
            font-font: "Nunito", sans-serif;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .search-box {
            position: relative;
            background: white;
            height: 40px;
            border-radius: 40px;
            padding: 10px;
            left: 225px;
        }

        .search-btn {
            color: #e84118;
            float: right;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.4s;
        }

        .search-txt {
            border: none;
            background: none;
            outline: none;
            float: left;
            padding: 0;
            color: black;
            font-size: 18px;
            transition: 0.4s;
            line-height: 40px;
            width: 500px;
        }

        nav {
            margin: 0;
            background: #3b3a3b;
            width: 100%;
            display: flex;
            align-items: center;
            border: 0px solid;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            height: 35px;
        }

        .logo {
            position: relative;
            width: 70px;
            height: 70px;
            left: 100px;
            overflow: hidden;
            border-radius: 100%;
        }

        @media all and (max-width: 800px) {
            .sidePanel {
                display: none;
            }
        }

        aside {
            margin: 0;
            position: absolute;
            background: #fff;
            width: 25%;
            top: 55px;
            display: flex;
            justify-content: center;
            height: -webkit-fill-available;
            border: 0px solid;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            background-image: url("https://picsum.photos/500/947");


        }

        .cuadro {
            position: absolute;
            background: white;
            width: 75%;
            height: 425px;
            top: 230px
        }

        .main .articles {
            width: 71%;
            margin-left: 2%;
            margin-right: 2%;
            float: right;

        }

        .main .articles article {
            margin-bottom: 20px;
        }

        .main .articles .article1 {
            margin: 0;
            padding: 0;
            margin-bottom: 20px;
            height: 300px;
            margin-top: 50px;
            left: -44%;
            position: relative;
        }

        .Contorno {
            width: 300px;
            height: 300px;
            background: #4db8ff;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            float: right;
        }

        .Badge {
            width: 270px;
            height: 270px;
            background: white;
            position: relative;
        }

        button {
            margin: 0;
            padding: 0;
            position: absolute;
            background: #4db8ff;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            left: 500px;
            transition: .6s;
        }

        .boton1 {
            margin: 0;
            padding: 10px;
            border: 0;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 50%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 28%;

        }

        .boton4 {
            margin: 0;
            padding: 10px;
            border: 0;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 50%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 84%;

        }

        .boton5 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 81%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 0%;

        }

        .boton6 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 81%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 28%;

        }

        .boton2 {
            margin: 0;
            padding: 10px;
            border: 0;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 50%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 56%;
        }

        .boton3 {
            top: 305px;
        }

        button {
            margin: 0;
            padding: 10px;
            border: 0;
            box-shadow: 5px 10px 30px #888888;
            left: 50%;
            background: #4db8ff;
            color: white;
            width: 300px;
            height: 50px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            position: relative;
            top: 0%;
        }

        .boton7 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 81%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 56%;
        }

        .boton8 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 81%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 84%;
        }

        .boton9 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 113%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 0%;
        }

        .boton10 {
            margin: 0;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
            position: absolute;
            left: 113%;
            background: #3b3a3b;
            color: white;
            width: 300px;
            height: 50px;
            border: 1px;
            font-size: 20px;
            overflow: hidden;
            transition: .6s;
            top: 28%;
        }

        button:focus {
            outline: none;
        }

        button:before {
            content: '';
            display: block;
            position: absolute;
            background: rgb(255, 255, 255, .5);
            width: 60px;
            height: 100%;
            left: 0;
            top: 0;
            opacity: .5s;
            filter: blur(30px);
            transform: rotateX(-130px) skewX(-15deg);
        }

        button::after {
            content: '';
            display: block;
            position: absolute;
            background: rgb(255, 255, 255, .2);
            width: 30px;
            height: 100%;
            left: 30px;
            top: 0;
            opacity: 0;
            filter: blur(30px);
            transform: translate(-100px) scaleX(-15deg);
        }

        button:hover {
            background: #3e413e;
            cursor: pointer;
        }

        button:hover:before {
            transform: translateX(300px) skewX(-15deg);
            opacity: .6;
            transition: .7s;
        }

        button:hover::after {
            transform: translateX(300px) skewX(-15deg);
            opacity: 1;
            transition: .7s;
        }

        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }


        .Playlist {
            margin: 0;
            background: #3b3a3b;
            height: 50px;
            color: white;
            text-align: -webkit-center;
            border: 0px solid;
            padding: 10px;
            box-shadow: 5px 10px 30px #888888;
        }

        .submitButton#buttonRegister {
            margin: 0;
            padding: 0;
            background: #4db8ff;
            width: 100px;
            height: 74px;
            position: absolute;
            right: 0px;
            text-align: center;
            line-height: 69px;
            font-size: 26px;
            font-family: "Nunito", sans-serif;
        }

        .profileInformation {
            margin: 0;
            font-size: 3vw;
            padding: 31px;
            line-height: 41px;
            text-align: right;
            font-family: times new roman, sans-serif;
            background: #ddd;
            color: black;
            box-shadow: 0px 0px 28px #ddd;
        }

        .logoSide {
            margin: 0;
            padding: 0;
            background: none;
            font-family: 'Nunito', sans-serif;
            padding-top: 0.32rem;
            padding-bottom: 0.32rem;
            margin-right: 1rem;
            font-size: 1.125rem;
            cursor: pointer;
            color: white;
        }


        .Header {
            margin: 0;
            padding: 0;
            position: absolute;
            width: 400px;
            right: -254px;
            height: 74px;

        }

        ul,
        ol {
            list-style: none;

        }

        .Nav li a {
            background-color: #fff;
            color: #3B3A3B;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            font-family: 'Nunito', sans-serif;
        }

        .Nav > li {
            float: left;
        }

        .Nav li a:hover {
            background-color: #434343;
            color: white;

        }

        .Nav li ul {
            display: none;
            position: absolute;
            min-width: 140px;
        }

        .Nav li:hover > ul {
            display: block;
        }
    </style>
</head>

<body>
<nav>
    {{--    <div>--}}
    {{--        <img class="logo" src="tumblr_pg8y3wKzm41tu65zm_540.jpg">--}}
    {{--    </div>--}}
    <div class="logoSide" id="logoPointer">
        Spectrum Explorer
    </div>
    {{--    <div class="search-box">--}}
    {{--        <input class="search-txt" type="text" name="" placeholder="Type to search">--}}
    {{--        <a class="search-btn" href="#">--}}
    {{--            <i class="fas fa-search"></i>--}}
    {{--        </a>--}}
    {{--    </div>--}}
    <div class="Header">
        <ul class="Nav">
            <li><a href="">Options</a>
                <ul>
                    <li><a href="http://projectobases.test/settings">Settings</a>
                    </li>
                    <li><a href="http://projectobases.test/register_new_info">Register</a>
                    </li>
                    <li><a href="http://projectobases.test/logout"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log
                            Out</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    {{--    <div class="submitButton" id="buttonRegister" >Register</div>--}}

</nav>
<section class="main">
    @yield('beginningSection')
    <aside class="sidePanel">
        <div class="Circle">
            <div><img class="circular--portrait" src="@yield('imageSource')"></div>
        </div>
        <div class="cuadro">

            <div class="profileInformation">
                @yield('information')
            </div>
        </div>
    </aside>
</section>

<script>
    // const submitButton = document.getElementById('buttonRegister')
    // submitButton.addEventListener("click", function () {
    //         window.location='http://projectobases.test/register';
    // });

    const logo = document.getElementById('logoPointer');

    logo.addEventListener("click", function () {
        window.location = 'http://projectobases.test/profile';

    });


</script>
</body>

</html>
