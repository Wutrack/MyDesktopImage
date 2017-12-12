<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}
    
    if(!isset($_GET['sh'])){$date='dateup';}
    
    if(isset($_GET['sh'])){
        if($_GET['sh']=='dateup'){
            $date='datedn';
        }else{
            $date='dateup';
        }
    }
    if(!isset($_GET['sh'])){$score='scoreup';}
    
    if(isset($_GET['sh'])){
        if($_GET['sh']=='scoreup'){
            $score='scoredn';
        }else{
            $score='scoreup';
        }
    }
    if(!isset($_GET['sh'])){$looking='lookingup';}
    
    if(isset($_GET['sh'])){
        if($_GET['sh']=='lookingup'){
            $looking='lookingdn';
        }else{
            $looking='lookingup';
        }
    }
    if(!isset($_GET['sh'])){$download='downloadup';}
    
    if(isset($_GET['sh'])){
        if($_GET['sh']=='downloadup'){
            $download='downloaddn';
        }else{
            $download='downloadup';
        }
    }
    if(!isset($_GET['sh'])){$bookmarks='bookmarksup';}
    
    if(isset($_GET['sh'])){
        if($_GET['sh']=='bookmarksup'){
            $bookmarks='bookmarksdn';
        }else{
            $bookmarks='bookmarksup';
        }
    }
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>Топ 100 картинок</title> 
    <link href="css/picture.css" rel="stylesheet">
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
        <div class="divSort">
            <?php include_once 'sort.php';?>
        </div>
        <div class="divSearch">
            <?php include_once 'search.php';?>
        </div>
        <div>
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            
            <?php

$num = 9; 
// Извлекаем из URL текущую страницу 
if(empty($_GET['page']))$page = 1;
else{$page = $_GET['page'];}
// Определяем общее число сообщений в базе данных 
$result = mysqli_query($db, "SELECT COUNT(*) FROM picture");
$posts = mysqli_fetch_row($result);
// Находим общее число страниц 
$total = 11;
// Определяем начало сообщений для текущей страницы 
$page = intval($page); 
// Если значение $page меньше единицы или отрицательно 
// переходим на первую страницу 
// А если слишком большое, то переходим на последнюю 
if(empty($page) or $page < 0) $page = 1; 
  if($page > $total) $page = $total; 
// Вычисляем начиная к какого номера 
// следует выводить сообщения 
$start = $page * $num - $num; 
// Выбираем $num сообщений начиная с номера $start 


    $result = mysqli_query($db,"SELECT * FROM picture WHERE allowed = '1' ORDER BY score DESC LIMIT $start, $num ");

// В цикле переносим результаты запроса в массив $postrow 
while ( $postrow[] = mysqli_fetch_array($result));

    if(!empty($postrow[0]['src'])){$src1 = 'img/' . $postrow[0]['category'] .'/mini'. $postrow[0]['src'];}
    if(!empty($postrow[1]['src'])){$src2 = 'img/' . $postrow[1]['category'] .'/mini'. $postrow[1]['src'];}
    if(!empty($postrow[2]['src'])){$src3 = 'img/' . $postrow[2]['category'] .'/mini'. $postrow[2]['src'];}
    if(!empty($postrow[3]['src'])){$src4 = 'img/' . $postrow[3]['category'] .'/mini'. $postrow[3]['src'];}
    if(!empty($postrow[4]['src'])){$src5 = 'img/' . $postrow[4]['category'] .'/mini'. $postrow[4]['src'];}
    if(!empty($postrow[5]['src'])){$src6 = 'img/' . $postrow[5]['category'] .'/mini'. $postrow[5]['src'];}
    if(!empty($postrow[6]['src'])){$src7 = 'img/' . $postrow[6]['category'] .'/mini'. $postrow[6]['src'];}
    if(!empty($postrow[7]['src'])){$src8 = 'img/' . $postrow[7]['category'] .'/mini'. $postrow[7]['src'];}
    if(!empty($postrow[8]['src'])){$src9 = 'img/' . $postrow[8]['category'] .'/mini'. $postrow[8]['src'];}
    
function img($src){
    include './session.php';
    $imdRes = mysqli_query($db, "SELECT width, height FROM picture WHERE src = '$src'");
    list($width, $height) = mysqli_fetch_row($imdRes);
    $del=$width/$height;
    if($del<1.6){
        return ' class="img"';
    }elseif ($del>=1.6 and $del<1.76) {
        return ' class="img17"';
    }elseif ($del>=1.76 and $del<1.9) {
        return ' class="img19"';
    }elseif ($del>=1.9) {
        return ' class="img2"';
    }
}

function altTag($idPicture){
    include './session.php';
    
    $quaryIdTag = "SELECT * FROM id_picturetag WHERE picture = '$idPicture'";
    $resultIdTag = mysqli_query($db, $quaryIdTag);
    echo mysqli_error($db);
    while ($idTag[] = mysqli_fetch_array($resultIdTag));
    $alt = ' alt="';
    $j=0;
    for($i=0; $i<20; $i++){
        
        if(!empty($idTag[$i]['idtag'])){
            
            $id = $idTag[$i]['idtag'];
            $quaryTagName = "SELECT nametag FROM id_nametag WHERE idtag = '$id'";
            $resultTagName = mysqli_query($db, $quaryTagName);
            $tagName = mysqli_fetch_array($resultTagName);
            
            if($j==0){
                $alt = "$alt$tagName[0]"; 
                $j++;
            }
            else{$alt = "$alt, $tagName[0]";}
        }  else {
            break;
        }
    }
    $alt = $alt.'"';
    return $alt;
}
    ?>
            <div class="pictures">
                <?php if(isset($postrow[0]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[0]['src']. '"><img src="' . $src1.'"'.img($postrow[0]['src']).altTag($postrow[0]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[1]['src'])){echo ' <div class="box">
   <a href="picture.php?img=' . $postrow[1]['src']. '"><img src=' . $src2.img($postrow[1]['src']).altTag($postrow[1]['idpicture']).'></a>
                </div>';}?>
                 <?php if(isset($postrow[2]['src'])){echo '<div class="box">
   <a href="picture.php?img=' . $postrow[2]['src']. '"><img src=' . $src3.img($postrow[2]['src']).altTag($postrow[2]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[3]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[3]['src']. '"><img src=' . $src4.img($postrow[3]['src']).altTag($postrow[3]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[4]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[4]['src']. '"><img src=' . $src5.img($postrow[4]['src']).altTag($postrow[4]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[5]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[5]['src']. '"><img src=' . $src6.img($postrow[5]['src']).altTag($postrow[5]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[6]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[6]['src']. '"><img src=' . $src7.img($postrow[6]['src']).altTag($postrow[6]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[7]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[7]['src']. '"><img src=' . $src8.img($postrow[7]['src']).altTag($postrow[7]['idpicture']).'></a>
                </div>';}?>
                <?php if(isset($postrow[8]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[8]['src']. '"><img src=' . $src9.img($postrow[8]['src']).altTag($postrow[8]['idpicture']).'></a>
                </div>';}?>
                <div class="break"></div>
                <div class="break"></div>
                <div class="break"></div>
             </div>    
                

    <div class="pages">
        <a href="./top100.php?page=1" <?php if($page == 1){echo 'class="disabled"';}?>>1</a>
        <a href="./top100.php?page=2" <?php if($page == 2){echo 'class="disabled"';}?>>2</a>
        <a href="./top100.php?page= 
              <?php if($page <=5){echo '3';}
                    if($page == 3){echo 'class="disabled"';}
                    if($page > 5){echo ($page-2);}
                    if($page >= ($total-6)){echo ($total-6);}?> ">
              
              <?php if($page <=5){echo '3';}
                    if($page > 5){echo ($page-2);}
                    if($page >= ($total-6)){echo ($total-6);}?></a>
        <a href="./top100.php?page=4" 
              <?php if($page <=5){echo '4';}
                    if($page == 4){echo 'class="disabled"';}
                    if($page > 5){echo ($page-1);}
                    if($page >= ($total-5)){echo ($total-5);}?> ">
            
              <?php if($page <=5){echo '4';}
                    if($page > 5){echo ($page-1);}
                    if($page >= ($total-5)){echo ($total-5);}?></a>
        <a href="./top100.php?page=
             <?php  if($page <=5){echo '5';}
                    if($page == 5){echo 'class="disabled"';}
                    if($page > 5){echo $page;}
                    if($page >= ($total-4)){echo ($total-4);}?>">
                    
             <?php  if($page <=5){echo '5';}
                    if($page > 5){echo $page;}
                    if($page >= ($total-4)){echo ($total-4);}?></a>
        <a href="./top100.php?page=
              <?php if($page <=5){echo '6';}
                    if($page == 5){echo 'class="disabled"';}
                    if($page > 5){echo ($page+1);}
                    if($page >= ($total-3)){echo ($total-3);}?>">
        
              <?php if($page <=5){echo '6';}
                    if($page > 5){echo ($page+1);}
                    if($page >= ($total-3)){echo ($total-3);}?></a>
        <a href="./top100.php?page=
              <?php if($page <=5){echo '7';}
                    if($page == 5){echo 'class="disabled"';}
                    if($page > 5){echo ($page+2);}
                    if($page >= ($total-2)){echo ($total-2);}?>">
                        
              <?php if($page <=5){echo '7';}
                    if($page > 5){echo ($page+2);}
                    if($page >= ($total-2)){echo ($total-2);}?></a>
        <a href="./top100.php?page=
              <?php echo ($total-1); 
                    if($page == ($total-1)){echo 'class="disabled"';}?>">
              <?php echo ($total-1)?></a>
        <a href="./top100.php?page=
              <?php echo $total;
                    if($page == $total){echo 'class="disabled"';}?>">
              <?php echo $total?></a>
    </div>
           
        </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>