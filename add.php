<?php
$time = date('H:i:s', time());
$user = $_POST['user'];
$post = $_POST['post'];
$recipient = $_POST['recipient'];
if (IsSet($_POST['post']))
{
$dbhost="mysql01.slezionp.beep.pl"; $dbuser="slezionap4"; $dbpassword="Kilof123$"; $dbname="z4_slezionp";
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
echo " MySQL Connection error." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}
$result = mysqli_query($connection, "INSERT INTO messages (message, user, recipient) VALUES ('$post', '$user','$recipient');") or die ("DB error: $dbname");
mysqli_close($connection);
}
header ('Location: index1.php');
?>
