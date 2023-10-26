<?php declare(strict_types=1);
session_start();
$isLogged = $_SESSION['loggedin'] ?? false;
if(!$isLogged) {
    header('Location: login.php');
    exit();
}

if(isset($_GET['delete'])) {
    $path = $_GET['path'];
    $endOfParentPath = strrpos($_SERVER['QUERY_STRING'], '/');
    $parentPath = 'drive.php?'.str_split($_SERVER['QUERY_STRING'], $endOfParentPath)[0];
    if(isset($_GET['type']) && $_GET['type'] == 'dir')
        rmdir($_SESSION['user_dir']."/".$path);
    else if(isset($_GET['type']) && $_GET['type'] == 'file')
        unlink($_SESSION['user_dir']."/".$path);
    header('Location: '.$parentPath);
    exit();
}

if(!isset($_GET['path']))
    header('Location: drive.php?path=');

$user = $_SESSION['user'];
$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap5', 'Kilof123$', 'z5_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); }

$userLoginInformation = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM users WHERE username='$user'"));
$lastFailedLogin = '';
if($userLoginInformation['failed_login_attempts'] > 0) {
    mysqli_query($link, "update users set failed_login_attempts=0, account_locked_until=null where username='$user'");
    $lastFailedLogin = mysqli_fetch_array(mysqli_query($link, "select * from break_ins where user='$user' order by date desc limit 1"));
}

$currentDir = $_GET['path'];
$userDir = $_SESSION['user_dir'];
$files = scandir($userDir."/".$currentDir);
if(!$files) header('Location: drive.php?path=');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dirName = $_POST['name'];
    mkdir($userDir."/".$currentDir."/".$dirName, 0777, TRUE);
    header("Location: drive.php?path=".$_GET['path']);
}


include(getcwd()."/DriverFile.php");
$tempArray = array();
foreach ($files as $file) {
    global $userDir;
    $filePath = $userDir."/".$currentDir."/".$file;
    $type = filetype($filePath);
    $size = filesize($filePath);
    $modified = fileatime($filePath);
    $f = new DriverFile($file, $modified, $type, $size, $filePath);
    array_push($tempArray, $f);
}

usort($tempArray, function($a,$b) {
    if($a->name == '..') return -1;
    if($b->name == '..') return 1;
    if($a->type == FileType::Dir && $b->type != FileType::Dir)
        return -1;
    else if($a->type != FileType::Dir && $b->type == FileType::Dir)
        return 1;
    else if(($a->type == FileType::Dir && $b->type == FileType::Dir) || ($a->type != FileType::Dir && $b->type != FileType::Dir)) {
        return strcmp(strtolower($a->name), strtolower($b->name));
    }
} );

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
    <link rel="stylesheet" type="text/css" href="drive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="twoj_js.js"></script>
</head>

<body onload="myLoadHeader()">
<div id='myHeader'> </div>
<div id="driverNav"">
    <i class="bi bi-folder-plus"></i>
    <i class="bi bi-cloud-upload"></i>
</div>
    <main>
        <?php
        if($lastFailedLogin != '')
            echo "<p style='color: red; padding-left: 5px'>Ostatnia nieudana próba logowania miała miejsce: ".$lastFailedLogin['date']." z adresu: ".$lastFailedLogin['ip'];
        ?>

        <table class="table">
            <tr>
                <th>Nazwa</th>
                <th>Podgląd</th>
                <th>Rozmiar</th>
                <th>Ostatnie zmiany</th>
                <th></th>
            </tr>
            <?php
            foreach ($tempArray as $f) {
                if($f->name == '.')
                    continue;
                if($currentDir == '' && $f->name == '..')
                    continue;
                echo $f->getFileRow();
            }
            ?>
        </table>
    </main>
<?php
?>
<div id="addDirectory">
    <form id="newDirectory" method="post" action="drive.php?path=<?php echo $_GET['path'] ?>" onsubmit="return validateDirectoryName()">
        <label for="name" class="form-label">Nazwa</label>
        <input id="dirName" type="text" name="name" class="form-control mb-3">
        <button type="submit" class="btn btn-primary">Utwórz</button>
    </form>
</div>
<form style="display: none" enctype="multipart/form-data" id="uploadFile" method="post" action="upload.php?path=<?php echo $_GET['path'] ?>&upload"">
    <input id="chooseFile" type="file" name="file" class="form-control mb-3">
</form>
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
        if(!dirName.match(/^[0-9a-zA-Z_]+$/)) {
            alert('Niedozwolone znaki w nazwie folderu');
            return false;
        }
        return true;
    }

    const fileInput = document.querySelector('#chooseFile');
    document.querySelector('.bi-cloud-upload').addEventListener('click', e => {
       fileInput.click();
    });
    fileInput.addEventListener('change', e => {
       document.querySelector('#uploadFile').submit();
    });
</script>
</html>