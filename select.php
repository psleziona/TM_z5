<?php declare(strict_types=1);
session_start();
$isLogged = $_SESSION['loggedin'] ?? false;
$loggedUser = $_SESSION['user'];
if(!$isLogged) {
    header('Location: login.php');
}

$dbhost="mysql01.slezionp.beep.pl"; $dbuser="slezionap5"; $dbpassword="Kilof123$"; $dbname="z5_slezionp";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
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
<div id='myHeader'> </div>
<main>
    <section class="sekcja1">
        <div class="container-fluid">
            <form onsubmit="return isFileAttach()" id="fileUpload" action="upload.php" method="post" enctype="multipart/form-data" class="col-lg-4">
                <div class="mb-3">
                    <label for="fileToUpload" class="form-label">Wybierz plik</label>
                    <input class="form-control" type="file" id="formFile" name="fileToUpload" accept=".jpg,.gif,.png,.mp3,.mp4">
                </div>
                <div class="mb-3">
                    <label for="recipient">Odbiorca</label>
                    <select name="recipient" class="form-select">
                        <?php
                        $users = mysqli_query($connection,'select * from users');
                        foreach ($users as $user)
                            if($user['username'] != $loggedUser)
                                echo "<option value=".$user['username'].">".$user['username']."</option>";
                        ?>
                    </select>
                </div>
                <input name="submit" type="submit" class="btn btn-outline-primary mb-3" value="Dodaj">
            </form>
        </div>
    </section>
</main>
<?php require_once 'footer.php'; ?>
</body>
<script>
    const isFileAttach = () => {
        if(document.querySelector('#formFile').files.length == 0) {
            alert("Dodaj plik");
            return false;
        }
        return true;
    }

</script>
</html>