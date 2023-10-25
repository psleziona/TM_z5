<?php declare(strict_types=1);
session_start();
$isLogged = $_SESSION['loggedin'] ?? false;
if(!$isLogged) {
    header('Location: login.php');
}

if(!isset($_GET['path']))
    header('Location: drive.php?path=');

$user = $_SESSION['user'];
$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap5', 'Kilof123$', 'z5_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD

$userLoginInformation = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM users WHERE username='$user'"));
$lastFailedLogin = '';
if($userLoginInformation['failed_login_attempts'] > 0) {
    mysqli_query($link, "update users set failed_login_attempts=0, account_locked_until=null where username='$user'");
    $lastFailedLogin = mysqli_fetch_array(mysqli_query($link, "select * from break_ins where user='$user' order by date desc limit 1"));
}


$currentDir = $_GET['path'];
$files = scandir($_SESSION['user_dir']."/".$currentDir);
if(!$files) header('Location: drive.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['name'];
    mkdir("./user_data/".$user."/".$currentDir."/".$dirName, 0777, TRUE);
//    header('Location: drive.php?path=');
    header("Refresh:0");
}
function getSizeModifiedTypeOfFile($fileName) {
    global $currentDir;
    $userDir = $_SESSION['user_dir'];
    $fileInfo = (object)array();
    $fileInfo->type = filetype($userDir."/".$currentDir."/".$fileName);
    $fileInfo->size = countSize(filesize($userDir."/".$currentDir."/".$fileName));
    $fileInfo->modified = fileatime($userDir."/".$currentDir."/".$fileName);
    return $fileInfo;
}

function countSize($size) {
    if($size > 1073741824)
        return round($size/1073741824, 2)." GB";
    if($size > 1048576)
        return round($size/1048576, 2)." MB";
    if($size > 1024)
        return round($size/1024, 2)." KB";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script type="text/javascript" src="twoj_js.js"></script>
    <style>
        #driverNav {
            font-size: 30px;
            padding: 0 10px;
        }

        #driverNav i:hover {
            color: #007bff;
            cursor: pointer;
        }

        #addDirectory {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: #958d8db5;
        }

        #newDirectory {
            width: 700px;
            margin: 0 auto;
            position: relative;
            top: 100px;
            border-radius: 13px;
            padding: 40px;
            background-color: white;
        }

        td>a {
            text-decoration: none;
            color: black;
        }

    </style>
</head>

<body onload="myLoadHeader()">
<div id='myHeader'> </div>
<div id="driverNav"">
    <i class="bi bi-folder-plus"></i>
</div>
    <main>
        <?php
        if($lastFailedLogin != '')
            echo "<p style='color: red; padding-left: 5px'>Ostatnia nieudana próba logowania miała miejsce: ".$lastFailedLogin['date']." z adresu: ".$lastFailedLogin['ip'];
        ?>
        <table class="table">
            <tr>
                <th>Nazwa</th>
                <th>Rozmiar</th>
                <th>Ostatnie zmiany</th>
            </tr>
            <?php
            foreach ($files as $fileName) {
                $file = getSizeModifiedTypeOfFile($fileName);
                $icon = $file->type == 'dir' ? '<i class="bi bi-folder"></i>' : '';
                $link = $file->type == 'dir' ? '<a href="drive.php?'.$_SERVER['QUERY_STRING'].'/'.$fileName.'">'.$icon.' '.$fileName.'</a>' : $icon.' '.$fileName;
                if($currentDir == '' && ($fileName == '.' || $fileName == '..'))
                    continue;
                if($fileName == '.')
                    continue;
                if($fileName == '..') {
                    $endOfParentPath = strrpos($_SERVER['QUERY_STRING'], '/');
                    $parentPath = str_split($_SERVER['QUERY_STRING'], $endOfParentPath)[0];
                    $link = '<a href="drive.php?'.$parentPath.'">'.$icon.'..</a>';
                }
                echo
                '<tr>
                    <td>'.$link.'</td>
                    <td>'.$file->size.'</td>
                    <td>'.date('Y-m-d H:i:s',$file->modified).'</td>
                </tr>';
            }
            ?>
        </table>
    </main>
<?php
?>
<div id="addDirectory">
    <form id="newDirectory" method="post" action="drive.php?<?php echo $_SERVER['QUERY_STRING'] ?>" onsubmit="return validateDirectoryName()">
        <label for="name" class="form-label">Nazwa</label>
        <input id="dirName" type="text" name="name" class="form-control mb-3">
        <button type="submit" class="btn btn-primary">Utwórz</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>
</body>
<script>
    document.querySelector('.bi-folder-plus').addEventListener('click', e => {
        document.querySelector('#addDirectory').style.display = 'block';
        document.querySelector('#dirName').focus();
    });

    document.querySelector('#addDirectory').addEventListener('click', e => {
       if(e.target === document.querySelector('#addDirectory'))
           document.querySelector('#addDirectory').style.display = 'none';
    });

    const validateDirectoryName = () => {
        const dirName = document.querySelector('#dirName').value;
        if(!dirName.match(/^[0-9a-zA-Z_]+$/))
            return false;
        return true;
    }
</script>
</html>