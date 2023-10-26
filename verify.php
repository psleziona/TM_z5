<?php
session_start();

$user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8");
$pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8");
$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap5', 'Kilof123$', 'z5_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
$rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
$ip = $_SERVER["REMOTE_ADDR"];

if($rekord['account_locked_until'] != null && strtotime($rekord['account_locked_until']) > time()) {
    header('Location: login.php?locked='.date('H:i:s', strtotime($rekord['account_locked_until'])));
} else {
    if($rekord && $rekord['password']==$pass)
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_dir'] = "./user_data/".$user;
        $_SESSION['user'] = $user;
        $_SESSION['avatar'] = $rekord['avatar'] != '' ? $rekord['avatar'] : 'defaultgray.png';

        $q = mysqli_query($link, "select * from goscieportalu where ipaddress='$ip'");
        $rec = mysqli_fetch_array($q);

        if($rec != null) {
            $counter = $rec['counter'];
            $counter++;
            $date = date('Y-m-d H:i:s', time());
            mysqli_query($link, "update goscieportalu set counter=".$counter.", datetime='$date' where ipaddress='$ip'");
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
        header('Location: drive.php');
    }
    else
    {
        $failedLoginAttempts = $rekord['failed_login_attempts'];
        if($failedLoginAttempts >= 2) {
            $accountLockedUntil = date("Y-m-d H:i:s", strtotime("+1 minute"));
            mysqli_query($link, "update users set account_locked_until='$accountLockedUntil'");
            mysqli_query($link, "insert into break_ins(ip, user) values ('$ip', '$user')");
        } else {
            $failedLoginAttempts++;
            mysqli_query($link, "update users set failed_login_attempts='$failedLoginAttempts'");
            echo "Błędny login lub hasło";
        }

        mysqli_close($link);
        header('Location: login.php?login=false');
    }
}
?>
