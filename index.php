<?php declare(strict_types=1);
    session_start();
    $isLogged = $_SESSION['loggedin'] ?? false;
    if(!$isLogged) {
        header('Location: login.php');
}
function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}?token=d1ec7fa4483660");
    $details = json_decode ($json);
    return $details;
}

function getBoolString($data) {
    return $data ? 'Dozwolone' : 'Zabronione';
}


$link = mysqli_connect('mysql01.slezionp.beep.pl', 'slezionap4', 'Kilof123$', 'z4_slezionp');
if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD

$result = mysqli_query($link, "select * from goscieportalu order by counter desc");
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
        <table class="table">
            <tr>
                <th>Data</th>
                <th>Adres IP</th>
                <th>Lokalizacja</th>
                <th>Współrzędne</th>
                <th>Google maps</th>
                <th>Używana przeglądarka</th>
                <th>Rozdzielczość ekranu</th>
                <th>Rozdzielczość przeglądarki</th>
                <th>Ilość kolorów</th>
                <th>Cookie?</th>
                <th>Aplety java?</th>
                <th>Język przeglądarki</th>
                <th>Ilość wejść na stronę</th>
            </tr>
            <?php
            foreach ($result as $data) {
                $details = ip_details($data['ipaddress']);


                if($details)
                    echo '<tr>
                        <td>'.$data['datetime'].'</td>
                        <td>'.$details -> ip.'</td>
                        <td>'.$details -> city.', '.$details -> region.', '.$details -> country.'</td>
                        <td>'.$details -> loc.'</td>
                        <td><a href="https://www.google.pl/maps/place/'.$details -> loc.'">LINK</a></td>
                        <td>'.$data['browser'].'</td>
                        <td>'.$data['resolution'].'</td>
                        <td>'.$data['browserResolution'].'</td>
                        <td>'.$data['colors'].'</td>
                        <td>'.getBoolString($data['cookies']).'</td>
                        <td>'.getBoolString($data['aplets']).'</td>
                        <td>'.$data['language'].'</td>
                        <td>'.$data['counter'].'</td>
                       </tr>';
            }

            ?>
        </table>
	</main>	
	<?php require_once 'footer.php'; ?>	
</body>
</html>