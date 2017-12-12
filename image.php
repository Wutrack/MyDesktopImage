<?php
session_start();
include './session.php';
$filename = $_GET['img'];
if(isset($_SESSION['login'])){
$login = $_SESSION['login'];


$query = "SELECT download FROM users WHERE login = '$login'";
$result = mysqli_query($db, $query);
list($userD) = mysqli_fetch_array($result);
$userD++;
mysqli_query($db, "UPDATE users SET download = '$userD' WHERE login = '$login'");}

$quary = "SELECT * FROM picture WHERE src = '$filename'";
$result = mysqli_query($db, $quary);
$picture[] = mysqli_fetch_array($result);
$idpicture = $picture[0]['idpicture'];
$d = $picture[0]['download'];
$d++;
mysqli_query($db, "UPDATE picture SET download = '$d' WHERE idpicture = '$idpicture'");

$src ='img/'.$picture[0]['category'].'/'.$filename;
?>
<img src="<?php echo $src?>">