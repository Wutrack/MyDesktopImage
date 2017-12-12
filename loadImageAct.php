<?php
session_start();
header('Content-type: text/html; charset=windows-1251');
include_once 'session.php';

$numrowsquary = "SELECT * FROM id_nametag";
$result = mysqli_query($db, $numrowsquary);
echo mysqli_error($db);
while($resultrow[] = mysqli_fetch_array($result));
$count = count($resultrow);

$privRes = mysqli_query($db, "SELECT privileges FROM users WHERE login = '$login'");

list($priv) = mysqli_fetch_row($privRes);

if(isset($_POST['category']))
    {$category = $_POST['category'];
    if($category == ''){unset($category);}
}
if(isset($_POST['tag']))
    {$tag = $_POST['tag'];
    if($tag == ''){unset($tag);}
}
if(isset($_SESSION['login']))
    {$autor = $_SESSION['login'];
    if($autor == ''){unset($autor);}
}

if(!empty($_POST['fupload'])){
    $fupload=$_POST['fupload'];    $fupload = trim($fupload);
    if ($fupload =='' or empty($fupload)) {
        unset($fupload);
    }
}
$size = getimagesize($_FILES['fupload']['tmp_name']);

if($size[0]<1280 or $size[1]<768){
    exit( 'Слишком маленькое разрешение картинки');
}

    if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name'])){
        $filename = $_FILES['fupload']['name'];
        $source = $_FILES['fupload']['tmp_name'];
        $pathDirectory = 'img/' . $category . '/';


        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $num = strlen($chars);
        $filename = '';
        for($i=0; $i<10; $i++){
            $filename.=substr($chars, rand(1, ($num-1)), 1);
        }
        $filename .= '.jpg';

        $target = $pathDirectory . $filename;

        $queryFilename = "SELECT idpicture FROM picture WHERE src='$filename'";
        $rusultFilename = mysqli_query($db, $queryFilename)or die("Error" . mysqli_error($db));
        $rusultFn = mysqli_fetch_array($rusultFilename);

        if(!empty($rusultFn['idpicture'])){
            $filename = '1'.$filename;
        }
        $allowed = 0;
        if($priv>2){$allowed = 1;}


        $query = "INSERT INTO picture (category,src,autor,data,bookmarks,allowed,width,height) VALUES('$category','$filename','$autor',now(),'0','$allowed',$size[0],$size[1])";
        $result = mysqli_query($db, $query);

        if($result){
            move_uploaded_file($source, $target);

            $queryIdPicture = "SELECT idpicture FROM picture WHERE src='$filename'";
            $idPictureResult = mysqli_query($db, $queryIdPicture);
            $idPicture = mysqli_fetch_array($idPictureResult);


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

                    $queryAddTagPicture ="INSERT INTO id_picturetag (idtag, picture) VALUES('$idTag[0]', '$idPicture[0]')";
                    $resultAddTagPicture = mysqli_query($db, $queryAddTagPicture);
                }
            }

            if(preg_match('/[.](GIF)|(gif)$/',    $filename)) {
                $im    = imagecreatefromgif($pathDirectory.$filename) ; //???? ???????? ??? ? ??????? gif, ?? ???????    ??????????? ? ???? ?? ???????. ?????????? ??? ???????????? ??????
            }
            if(preg_match('/[.](PNG)|(png)$/',    $filename)) {
                $im =    imagecreatefrompng($pathDirectory.$filename) ;//????    ???????? ??? ? ??????? png, ?? ??????? ??????????? ? ???? ?? ???????.    ?????????? ??? ???????????? ??????
            }
            if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
                $im =    imagecreatefromjpeg($pathDirectory.$filename); //???? ???????? ??? ? ??????? jpg, ?? ??????? ??????????? ? ???? ??    ???????. ?????????? ??? ???????????? ??????
            }



            $w = 500;
            $h = 550;

            $ratio_orig = $size[0]/$size[1];

            if ($w/$h > $ratio_orig) {
               $w = $h*$ratio_orig;
            } else {
               $h = $w/$ratio_orig;
            }


            $image = imagecreatetruecolor($w, $h);
            imagecopyresampled($image, $im, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

            imagejpeg($image,$pathDirectory.'mini'.$filename);

            if($allowed==1){
                $queryUserUpload = "SELECT upload FROM users WHERE login ='$login'";
                $resultUserUpload = mysqli_query($db, $queryUserUpload);
                list($UserUpload) = mysqli_fetch_row($resultUserUpload);
                $UserUpload++;
                mysqli_query($db, "UPDATE users SET upload = '$UserUpload' WHERE login ='$login'");
            }

            echo 'Ваша картинка "'.$filename.'" успешно загружена и ожидает модерации!';
        }else{
            echo mysqli_error($db);
            echo 'Ошибка! Что-то пошло не так >_>';
        }
    }else{
    exit ("Картинка должна быть только в форматах <strong>JPG, GIF, PNG</strong>");
    }



?>