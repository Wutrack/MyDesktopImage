<?php
    session_start();
    header("Content-Type: text/html; charset=Windows-1251");
    include_once 'session.php';
    $srcP = $_GET['img'];
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>Картинка на рабочий стол, обои: <?php echo altTag($srcP);?> </title> 
<?php    
    function altTag($srcP){
    include './session.php';
    
    $quary1 = "SELECT * FROM picture WHERE src = '$srcP'";
    $result1 = mysqli_query($db, $quary1);
    $category1[] = mysqli_fetch_array($result1);
    
    $idPicture1 = $category1[0]['idpicture'];
    
    $quaryIdTag1 = "SELECT * FROM id_picturetag WHERE category = '$idPicture1'";
    $resultIdTag1 = mysqli_query($db, $quaryIdTag1);
    echo mysqli_error($db);
    while ($idTag1[] = mysqli_fetch_array($resultIdTag1));
    $alt = '';
    $j=0;
    for($i=0; $i<20; $i++){
        
        if(!empty($idTag1[$i]['idtag'])){
            
            $id1 = $idTag1[$i]['idtag'];
            $quaryTagName1 = "SELECT nametag FROM id_nametag WHERE idtag = '$id1'";
            $resultTagName1 = mysqli_query($db, $quaryTagName1);
            $tagName1 = mysqli_fetch_array($resultTagName1);
            
            if($j==0){
                $alt = "$alt$tagName1[0]"; 
                $j++;
            }
            else{$alt = "$alt, $tagName1[0]";}
        }  else {
            break;
        }
    }
    $alt = $alt.'';
    return $alt;
}
    ?>
    <meta name="description" content="Картинки на рабочий стол. Самые лучшие картинки для рабочего стола попадают к нам. Вы можете бесплатно скачать классные картинки. Новые бесплатные широкоформатные картинки только для вас.">
    <link href="css/picture.css" rel="stylesheet">
    <link href="css/office.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.1.0.js"></script>
</head>
<body>

    <div class="mainDiv">
        <div class="title edit">
            <?php
            if(!isset($myrow['idusers'])){
                include 'navNotLogin.php';
            }else{
                include 'navYesLogin.php';}
            ?>
        </div>
        <div class="aNav">
            <?php include_once 'navCategory.php';?>
        </div>
        <div class="pictureBox">
            <?php include_once 'pictureView.php';?>
        </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>