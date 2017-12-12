<?php
    session_start();
    
    include_once 'session.php';
    
    $queryPicture = "SELECT * FROM picture WHERE allowed = '0'";
    $resultPicture = mysqli_query($db, $queryPicture);
    while ($picture[] = mysqli_fetch_array($resultPicture));

    $queryTagName = "SELECT * FROM id_nametag WHERE allowed = '0'";
    $resultTagName = mysqli_query($db, $queryTagName);
    while ($tagName[] = mysqli_fetch_array($resultTagName));

    $queryTagId = "SELECT * FROM id_picturetag WHERE allowed = '0'";
    $resultTagId = mysqli_query($db, $queryTagId);
    while ($tagId[] = mysqli_fetch_array($resultTagId));
?>
<html>
<head>
    <title>MyDesktopImage</title> 
    <link href="css/picture.css" rel="stylesheet">
    <link href="css/office.css" rel="stylesheet">
</head>
<body>
    <div class="mainDiv">
        <div class="title">
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
            <div class="allowing">
        <?php
//-------------------------------------------------------------------------------------
            $countPicture = count($picture)-1;
            echo '<p>Подтвердить картинку</p>';
            for($i=0; $i<$countPicture;$i++){

                $category = $picture[$i]['category'];
                $filename = $picture[$i]['src'];
                if(!empty($category)){
                    $src = 'img/' . $category .'/mini'. $filename;
                }

                echo  '<div class="boxPic">'
                    . '<a href="picture.php?img=' . $filename. '">'
                    . '<img src='. $src .'>'
                    . '</a>' . '</div>';
            }
//-------------------------------------------------------------------------------------
            $countTagName = count($tagName)-1;
            echo '<p>Подтвердить тег</p>';

            for($i=0; $i<$countTagName;$i++){

                echo  '<div class="boxTag">'
                    . '<span class="allowingSpan">'.$tagName[$i]['nametag'].'</span>'
                    . '<span class="alPlus">+</span>'
                    . '<span class="alMinus">-</span>'
                    . '<span>Редактировать</span>'
                    . '</div>';
            }
//-------------------------------------------------------------------------------------
            $countTagId = count($tagId)-1;

            echo '<p>Подтвердить тег к картинке</p>';
            for($i=0; $i<$countTagId;$i++){

                $tagPicQ = $tagId[$i]['picture'];
                $tagIdQ = $tagId[$i]['idtag'];

                $queryPicture1 = "SELECT * FROM picture WHERE idpicture = '".$tagPicQ."'";
                $resultPicture1 = mysqli_query($db, $queryPicture1);
                while ($picture1[] = mysqli_fetch_array($resultPicture1));
                echo mysqli_error($db);

                $queryTagName1 = "SELECT * FROM id_nametag WHERE idtag = '".$tagIdQ."'";
                $resultTagName1 = mysqli_query($db, $queryTagName1);
                while ($tagName1[] = mysqli_fetch_array($resultTagName1));
                echo mysqli_error($db);


                $category1 = $picture1[$i]['category'];
                $filename1 = $picture1[$i]['src'];
                $nameTag1 = $tagName1[$i]['nametag'];
                $src1 = 'img/' . $category1 .'/mini'. $filename1;

                echo  '<div class="boxPic">'
                    . '<a href="picture.php?img=' . $filename1. '">'
                    . '<img src='. $src1 .'>'
                    . '</a>'
                    . '<span class="allowingSpan">'.$tagName1[$i]['nametag'].'</span>'
                    . '<span class="alPlus">+</span>'
                    . '<span class="alMinus">-</span>'
                    . '<span>Редактировать</span>'
                    . '</div>';
            }
//-------------------------------------------------------------------------------------
        ?>
        </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>