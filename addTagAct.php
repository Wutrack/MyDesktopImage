<?php
session_start();
header('Content-type: text/html; charset=windows-1251');
include_once 'session.php';

$numrowsquary = "SELECT * FROM id_nametag";
$result = mysqli_query($db, $numrowsquary);
while($resultrow[] = mysqli_fetch_array($result));
$count = count($resultrow);

$privRes = mysqli_query($db, "SELECT privileges FROM users WHERE login = '$login'");
list($priv) = mysqli_fetch_row($privRes);
$allowed = 0;
if($priv>2){$allowed = 1;}

If(isset($login)){
    $privRes = mysqli_query($db, "SELECT privileges FROM users WHERE login = '$login'");
    $priv = mysqli_fetch_array($privRes);
}

if(isset($_POST['tag']))
    {$tag = $_POST['tag'];
    if($tag == ''){unset($tag);}
}
if(isset($_SESSION['login'])) {
    $autor = $_SESSION['login'];
    if($autor == ''){unset($autor);}
}

$id = $_GET['id'];

echo id." - id1   ";

$tag = iconv('UTF-8', 'windows-1251', $tag);
$tagM = explode(", ", $tag);
$tc = 0;

if(isset($tagM)){
    for($j = 0; $j<count($tagM); $j++){
        $tcc = true;
        for($i=0; $i < $count; $i++){
            if($tagM[$j] == $resultrow[$i]['nametag']){
                echo "sdfsdsadfsad   $tagM[$j]  ";
                $tcc = false;
            }
        }
        if($tcc){
            $tagNew[$tc] = $tagM[$j];
            $tc++;
        }
    }
    for($i=0; $i<count($tagNew); $i++){
        if(!empty($tagNew[$i])){
            $addtag = "INSERT INTO id_nametag (nametag, allowed) VALUES('$tagNew[$i]', '$allowed')";
            mysqli_query($db, $addtag);
        }
    }

    for($i=0; $i<count($tagM); $i++){

        $queryIdTag = "SELECT idtag FROM id_nametag WHERE nametag='$tagM[$i]'";
        $idTagResult = mysqli_query($db, $queryIdTag);
        $idTag = mysqli_fetch_array($idTagResult);
        echo id." - id2   ";

        $queryAddTagPicture ="INSERT INTO id_picturetag (idtag, picture, allowed) VALUES('$idTag[0]', '$id', '$allowed')";
        $resultAddTagPicture = mysqli_query($db, $queryAddTagPicture);
    }
}
echo mysqli_error($db);
?>