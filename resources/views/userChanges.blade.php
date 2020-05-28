<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>

    body {
        overflow: hidden;
    }

    h1 {
        font-size: 50px;
    }

    container.left {
        height: -webkit-fill-available;
        position: absolute;
        width: 50%;
    }

    container.right {
        height: -webkit-fill-available;
        position: absolute;
        width: 50%;
        right: -1%;
        overflow: auto;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        position: absolute;
    }


    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .textBox {
        border-radius: 10px;
        position: absolute;
        left: 13%;
        width: 415px;
        text-align: center;
    }

    #buttonSubmit {
        border-radius: 13px;
        width: 75%;
        position: absolute;
        left: 3%;
        height: 44px;
        background: white;
    }

    #goBackButton {
        border-radius: 13px;
        width: 75%;
        position: absolute;
        left: 3%;
        height: 44px;
        background: white;
        top: 14%;
    }

</style>
<body style="overflow: hidden">
<h1>User Role Change</h1>

<container class="left">
    <label>Username ID:</label>
    <input type="text" class="textBox" id="usernameBox" placeholder="User ID..."><br><br>

    <label for="fname">New Role ID:</label>
    <input type="text" class="textBox" id="idNumber" placeholder="Role Name ID..."><br><br>

    <input type="button" value="Update" id="buttonSubmit">
    <input type="button" value="Go back" id="goBackButton">

</container>
<container class="right" style="overflow: auto">
    <h3>Users</h3>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Role Id</th>
            <th>Role Name</th>
        </tr>
        @foreach($userRoles as $table)
            <tr>
                <td>
                    {{$table->userid}}
                </td>
                <td>
                    {{$table->username}}
                </td>
                <td>
                    {{$table->roleid}}
                </td>
                <td>
                    {{$table->rolename}}
                </td>
            </tr>
        @endforeach


    </table>


</container>
<div class="roleTable" style="position: relative; top:350px; width: 50%">
    <h3>Roles</h3>
    <table>
        <tr>
            <th>Role Id</th>
            <th>Role Name</th>
        </tr>
        @foreach($roles as $table)
            <tr>
                <td>
                    {{$table->id}}
                </td>
                <td>
                    {{$table->name}}
                </td>
            </tr>
        @endforeach
    </table>
    <br><br><br><br>
    <br><br><br><br>
    <br><br><br><br>
    Instrucciones <br>
    1. Revisar en la tabla <b>Users</b> y revisar <br>
    apuntar el ID del usuario que se quiere modificar <br>
    2. Tomar el ID y apuntarlo en la textbox más alta. <br>
    3. Apuntar, en la segunda Textbox, el id del <b>Rol</b> al que se quiera cambiar
</div>

<script>
    const updateButton = document.getElementById('buttonSubmit');
    const goBackButton = document.getElementById('goBackButton');

    updateButton.addEventListener('click', function () {
        if (document.getElementById('usernameBox').value != '' && document.getElementById('idNumber').value != '') {
            url = 'http://projectobases.test/changeRole/';
            userid = document.getElementById('usernameBox').value;
            newrole = document.getElementById('idNumber').value;
            window.location.href = `${url}${userid}/${newrole}}`
        } else alert('All text boxes must be filled')
    });

    goBackButton.addEventListener('click', function () {
        window.location.href = 'http://projectobases.test/profile'
    })


</script>

</body>
</html>
