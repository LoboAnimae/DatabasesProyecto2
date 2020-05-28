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
<h1>Change User Roles</h1>

<container class="left">
    <label>Username:</label>
    <input type="text" class="textBox" id="usernameBox" placeholder="User ID..."><br><br>

    <label for="fname">ID:</label>
    <input type="text" class="textBox" id="idNumber" placeholder="Change To..."><br><br>

    <input type="button" value="Change" id="buttonSubmit">
    <input type="button" value="Go back" id="goBackButton">

</container>
<container class="right">
    <?php
    $users = \App\User::all();
    print('<table style="width: 90%"><tr><th style="text-align: center">ID</th><th style="text-align: center">Username</th></tr>');
    foreach ($users as $user) {
        $userid = $user->id;
        $username = $user->name;
        print('<tr><td style="text-align: center">' . $userid . '</td><td style="text-align: center">' . $username . '</td></tr>');
    }
    print('</table>');
    ?>
</container>

<script>
    const username = document.getElementById('usernameBox')
    const id = document.getElementById('idNumber')
    const submit = document.getElementById('buttonSubmit')
    const goBack = document.getElementById('goBackButton')

    submit.addEventListener('click', function () {
        if (username.value != '' && id.value != '') {
            if (confirm('Are you sure?')) {
                window.location = `http://projectobases.test/changeRole/${username.value}/${id.value}`
            } else alert('Operation Canceled')
        }
    })

    goBack.addEventListener('click', function(){
        window.location = 'http://projectobases.test/profile'
    })




</script>

</body>
</html>
