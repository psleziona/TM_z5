<?php
session_start();
$user = $_SESSION['user'];
$recipient = $_POST['recipient'];

$target_dir = "./user_data/".$user;
$target_file = $target_dir . "/". basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"]))
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) { echo "File is an image - " . $check["mime"] . "."; $uploadOk = 1; }
    else { echo "File is not an image."; $uploadOk = 0; }
}
 // Check if file already exists
if (file_exists($target_file)) { echo "Sorry, file already exists."; $uploadOk = 0; }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 2000000) { echo "Sorry, your file is too large."; $uploadOk = 0; }
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "mp4" && $imageFileType != "gif" && $imageFileType != "mp3" ) {
    echo "Sorry, only JPG, PNG, GIF, MP3 & MP4 files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) { echo "Sorry, your file was not uploaded."; }
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        $dbhost = "mysql01.slezionp.beep.pl";
        $dbuser = "slezionap4";
        $dbpassword = "Kilof123$";
        $dbname = "z4_slezionp";
        $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$connection) {
            echo " MySQL Connection error." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $fileN = $_FILES["fileToUpload"]["name"];
        $result = mysqli_query($connection, "INSERT INTO messages (message, user, recipient) VALUES ('$fileN', '$user','$recipient');") or die ("DB error: $dbname");
        header('Location: index1.php');
    }
    else { echo "Sorry, there was an error uploading your file."; }
 }
?>