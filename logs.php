<?php declare(strict_types=1);
session_start();
$isLogged = $_SESSION['loggedin'] ?? false;
if(!$isLogged) {
    header('Location: login.php');
}

$user = $_SESSION['user'];
if($user != 'admin')
    header('Location: drive.php');

$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap5', 'Kilof123$', 'z5_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD

$result = mysqli_query($link, "select * from break_ins");

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Twój Opis">
    <meta name="author" content="Twoje dane">
    <meta name="keywords" content="Twoje słowa kluczowe">
    <title>Śleziona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <style type="text/css" class="init"></style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script>
</head>

<body onload="myLoadHeader()">
<div id='myHeader'></div>
<main>
    <table class="table table-striped">
        <tr>
            <th>Data</th>
            <th>IP</th>
            <th>Login</th>
        </tr>
        <?php
            foreach ($result as $data)
                echo "<tr>
                        <td>".$data['date']."</td>
                        <td>".$data['ip']."</td>
                        <td>".$data['user']."</td>
                      </tr>";
        ?>
    </table>
</main>
<?php require_once 'footer.php'; ?>
</body>
</html>