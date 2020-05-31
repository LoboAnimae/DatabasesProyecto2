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
                    style="margin: 0;padding: 10px;border: 0;box-shadow: 5px 10px 30px #888888;;left: 50%;background: #3B3A3B;color: white;width: 300px;height: 50px;font-size: 20px;overflow: hidden;transition: .6s;position: relative;top: 0%;">
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
                <button class="boton10" id="changeLog">Check the Changelog</button>

            @endif


        </article>

        <style>
            tr:nth-child(even) {
                background-color: #3b3a3b;
                color: white;
                text-decoration: none;
                font-size: x-large;
            }

            tr:nth-child(even) a {
                text-decoration: none;
                font-size: x-large;
                background-color: #3b3a3b;
                color: white;
            }
        </style>
        <hr>
        <article>
            <div class="Playlist">
                <h2>Your Tracks</h2>
                <div class="tableContainer"
                     style="overflow: auto;height: 45vh;position: relative;top: 34px;width: 100%;display: flex;">
                    <table
                        style="font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%; color: black;">
                        @foreach ($ownedTracks as $trackstable)
                            <tr>
                                <td style="width: 20%; word-wrap: break-spaces; text-align: center; font-weight: bolder; padding: 20px;">
                                    {{ $trackstable->artistname }}
                                </td>
                                <td style="width: 20%; word-wrap: break-spaces; text-align: center; padding: 20px;">
                                    {{ $trackstable->albumtitle }}
                                </td>
                                <td style=" border: 1px solid #3B3A3B; text-align: center;  padding: 20px;">
                                    {{ $trackstable->trackname }}
                                </td>
                                @if ($trackstable->trackurl == null)
                                    <td style="text-align: center"> Not Available</td>
                                @else
                                    <td
                                        style="font-size: x-large; text-decoration: none; color: #3B3A3B;  padding: 20px;; border: 1px solid #3B3A3B; background-color: white; text-align: center">
                                        <a href={{ $trackstable->trackurl }} style="font-size: x-large; text-decoration:
                                           none; color: #3B3A3B; background-color: white">
                                        Listen on YouTube</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
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

        const changelog = document.getElementById('changeLog')
        changelog.addEventListener('click', () => {
            window.location.href = 'http://projectobases.test/changelog'
        })

    </script>


@endsection
