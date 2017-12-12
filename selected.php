<?php

    session_start();
    include './session.php';
    if(isset($_GET['img'])){
        $filename = $_GET['img'];
    }
    
    $idUserQuery = "SELECT idusers FROM users WHERE login ='$login'";
    $idUserRes = mysqli_query($db, $idUserQuery);
    list($idUser) = mysqli_fetch_row($idUserRes);
    
    $idPictureQuery = "SELECT idpicture, bookmarks FROM picture WHERE src ='$filename'";
    $idPictureRes = mysqli_query($db, $idPictureQuery);
    list($idPicture, $bm) = mysqli_fetch_row($idPictureRes);
    
    $idUPquery = "SELECT id FROM selected WHERE iduser ='$idUser' and idpicture='$idPicture'";
    $idUPRes = mysqli_query($db, $idUPquery);
    list($idS) = mysqli_fetch_row($idUPRes);
    if(isset($idS)){
        $idUPdel = "DELETE FROM selected WHERE iduser = '$idUser' and idpicture = '$idPicture'";
        $idUPdelRes = mysqli_query($db, $idUPdel) or die( exit('Del error: '.mysqli_error($db)));
        $bm -=1;
        $bmUpdate = "UPDATE picture SET bookmarks = '$bm' WHERE src ='$filename'";
        mysqli_query($db, $bmUpdate);
        echo '<a id="sel">
            <img src="icon/izbrannoe.jpg"></a>';
    }else{
        $idUPinsert = "INSERT INTO selected (idpicture, iduser) VALUES ('$idPicture', '$idUser')";
        $idUPinsertRes = mysqli_query($db, $idUPinsert) or die( exit('Insert error: '.mysqli_error($db)));
        $bm +=1;
        $bmUpdate = "UPDATE picture SET bookmarks = '$bm' WHERE src ='$filename'";
        mysqli_query($db, $bmUpdate);
        echo '<a id="unsel">'.
            '<img src="icon/neizbrannoe.jpg"></a>';
    }
    
    
?>