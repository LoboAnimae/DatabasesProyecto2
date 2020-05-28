{{--Profile Information--}}
{{--
This class extends the main template, but it is also the first screen that a user sees
wheh they first open the webPage

Pages that take here:
    - Login/Registration Page
    - Any page with the logo on the top left

Pages that can be gone to through here:
    - Search
    - Login
    - Settings
--}}
@extends('main_template')


@section('information')
    <p3 style="color: #000;line-height: 41px;margin: 0;padding: 0;font-family: 'Nunito', sans-serif;font-size: 2vw;">
        Profile Name
    </p3><br>
    <p1>{{$user->name}}</p1> <br><br><br>
    <p4 style="color: #000;line-height: 41px;margin: 0;padding: 0;font-family: 'Nunito', sans-serif; font-size: 2vw;">
        Profile Code
    </p4> <br>
    <p2>{{$user->id}}</p2>
    <br><br><br>

    {{$roleValue}}




@endsection

@section('imageSource')
    https://picsum.photos/200/300
@endsection

@section('beginningSection')
    <section class="articles">
        <article class="article1">
            <button id="search"
                    style="margin: 0;padding: 10px;border: 0;box-shadow: 5px 10px 30px #888888;;left: 50%;background: #70869e;color: white;width: 300px;height: 50px;font-size: 20px;overflow: hidden;transition: .6s;position: relative;top: 0%;">
                Search
            </button>
            <button class="boton1" id="upload">Upload</button>
            <button class="boton4" id="Delete">Delete</button>
            <button class="boton2" id="fun_statistics">Fun Statistics</button>
            @if($roleValue == 'SuperUser')
                <button class="boton5" id="hideSong">Hide a song</button>
                <button class="boton6" id="userChanges">Erase Users</button>
                <button class="boton7" id="changeRoles">Change User Roles</button>
                <button class="boton8" id="updateInfo">Change Some Info</button>
                <button class="boton9" id="cvsPage">Generate Invoice CVS</button>
                <button class="boton10" id="mongoPage">Check Mongo Connection</button>
            @endif


        </article>
        <hr>
        <article>
            <div class="Playlist">
                <h2>Playlist</h2>
            </div>
        </article>
    </section>

    <script>
        const search = document.getElementById('search');
        search.addEventListener('click', function () {
            window.location = 'http://projectobases.test/searchQuery'
        });

        const uploadButton = document.getElementById('upload');
        uploadButton.addEventListener("click", function () {
            window.location = 'http://projectobases.test/register_new_info';
        });

        const funStats = document.getElementById('fun_statistics');

        funStats.addEventListener('click', function () {
            window.location = 'http://projectobases.test/statistics'
        });

        const deleteButton = document.getElementById('Delete');
        deleteButton.addEventListener('click', function () {
            window.location = 'http://projectobases.test/delete'
        });

        const updateInformation = document.getElementById('hideSong');
        updateInformation.addEventListener('click', function () {
            window.location = 'http://projectobases.test/hide'
        });

        const userChanges = document.getElementById('userChanges');
        userChanges.addEventListener('click', function () {
            window.location = '/userChanges'
        });

        const rolesChange = document.getElementById('changeRoles');
        rolesChange.addEventListener('click', function () {
            window.location.href = 'http://projectobases.test/changeRoles'
        });

        const changeInfo = document.getElementById('updateInfo');
        changeInfo.addEventListener('click', function () {
            window.location.href = 'http://projectobases.test/updateInfo'
        })

        const generateCSV = document.getElementById('cvsPage')
        generateCSV.addEventListener('click', () => {
            window.location.href = 'http://projectobases.test/generateCSV'
        })

        const mongoConnection = document.getElementById('mongoPage')
        mongoConnection.addEventListener('click', () => {
            window.location.href = 'http://projectobases.test/mongo'
        })

    </script>


@endsection
