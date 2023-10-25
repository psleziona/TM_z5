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
                <form method="POST" action="add.php" class="col-lg-4">
                    <div class="mb-3">
                        <label for="user" class="form-label">Nick:</label>
                        <input class="form-control" type="text" name="user" readonly value="<?php echo $loggedUser; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="post" class="form-label">Post:</label>
                        <input type="text" name="post" class="form-control form-control-lg">
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

                    <button type="submit" class="btn btn-outline-primary mb-3">Dodaj</button>
                </form>
                <?php
                $q = $loggedUser == 'admin' ? '' : "where user='$loggedUser' or recipient='$loggedUser'";
                $result = mysqli_query($connection, "Select * from messages ".$q." order by idk desc") or die ("DB error: $dbname");
                print "<TABLE class='table'>";
                print "<TR><TD>id</TD><TD>Date/Time</TD><TD>User</TD><TD>Message</TD></TR>\n";
                while ($row = mysqli_fetch_array ($result))
                {
                    $id = $row[0];
                    $date = $row[1];
                    $message= $row[2];
                    $user = $row[3] != '' ? $row[3] : $_SESSION['user'];
                    $style = $loggedUser == $row[3] ? "style='background-color: #ffffb3'" : "style='background-color: #fff6ec'";
                    if(str_contains($message, '.png') || str_contains($message, '.jpg') || str_contains($message, '.gif'))
                        $message = "<img src='user_data/".$user."/".$message."'>";
                    else if(str_contains($message, '.mp3'))
                        $message = "<audio controls src='user_data/".$user."/".$message."'>";
                    else if(str_contains($message, '.mp4'))
                        $message = "<video controls autoplay muted width='250'> 
                    <source src='user_data/".$user."/".$message."' type='video/mp4'>
                </video>";

                    print "<TR ".$style.">
        <TD>$id</TD>
        <TD>$date</TD>
        <TD>$user</TD>
        <TD>$message</TD>
       </TR>\n";
                }
                print "</TABLE>";
                mysqli_close($connection);
                ?></div>
        </section>
    </main>
    <?php require_once 'footer.php'; ?>
    </body>
    </html>






