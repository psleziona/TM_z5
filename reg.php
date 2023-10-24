<?php
$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); 
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8");
$pass2 = htmlentities ($_POST['pass2'], ENT_QUOTES, "UTF-8");
 $link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap4', 'Kilof123$', 'z4_slezionp'); // połączenie z BD – wpisać swoje dane
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
 mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
if($pass != $pass2) {
    echo 'Hasła nie pasują do siebie';
} else {
    mkdir("./user_data/".$user, 0777, TRUE);
    $target_dir = "./avatars/";
    $fileName = basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

    mysqli_query($link, "insert into users(username,password,avatar) values('$user','$pass','$fileName')");
    header('Location: index.php');
}

?>