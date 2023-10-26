<?php
session_start();
$user = $_SESSION['user'];
$currentDir = $_GET['path'];
$userDir = $_SESSION['user_dir'];

$target_dir = "./user_data/".$user;
$target_file=$userDir."/".$currentDir."/".basename($_FILES['file']['name']);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (file_exists($target_file)) { echo "Sorry, file already exists."; $uploadOk = 0; }
if ($_FILES["file"]["size"] > 104857600) { echo "Sorry, your file is too large. Maximum size is 100 MB"; $uploadOk = 0; }
if ($uploadOk == 0) { echo "Sorry, your file was not uploaded."; }
else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $dbhost = "mysql01.slezionp.beep.pl";
        $dbuser = "slezionap5";
        $dbpassword = "Kilof123$";
        $dbname = "z5_slezionp";
        $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$connection) {
            echo " MySQL Connection error." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        header("Location: drive.php?path=".$_GET['path']);
    }
    else { echo "Sorry, there was an error uploading your file."; }
 }
?>