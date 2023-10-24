<?php
$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8");
$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap4', 'Kilof123$', 'z4_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
if($rekord && $rekord['password']==$pass) //Jeśli brak, to nie ma użytkownika o podanym loginie
{
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = $user;
    $_SESSION['avatar'] = $rekord['avatar'] != '' ? $rekord['avatar'] : 'defaultgray.png';


    $ip = $_SERVER["REMOTE_ADDR"];
    $q = mysqli_query($link, "select * from goscieportalu where ipaddress='$ip'");
    $rec = mysqli_fetch_array($q);


    if($rec != null) {
        $counter = $rec['counter'];
        $counter++;
        mysqli_query($link, "update goscieportalu set counter=".$counter." where ipaddress='$ip'");
    } else {
        include(getcwd()."/Browser/src/Browser.php");
        $browser = new Browser();
        $version = $browser->getVersion();
        $browserName = $browser->getBrowser();

        $browser = $browserName.' '.$version;
        $resolution = $_GET['resolution'];
        $browserResolution = $_GET['browserResolution'];
        $colors=$_GET['colors'];
        $cookies = $_GET['cookies'];
        $aplets = $_GET['aplets'];
        $language = $_GET['lang'];

        mysqli_query($link, "insert into goscieportalu(ipaddress, browser, resolution, browserResolution, colors, cookies, aplets, language)
                                                values('$ip','$browser','$resolution','$browserResolution','$colors',$cookies,$aplets,'$language')");
    }
    header('Location: index.php');
}
else
{
    mysqli_close($link);
    header('Location: login.php');
}

?>
