<?php
include './session.php';

$num = 15;
// Извлекаем из URL текущую страницу 
if(empty($_GET['page'])){
    $page = 1;
}else{$page = $_GET['page'];}
// Определяем общее число сообщений в базе данных

$query = 'SELECT COUNT(*) FROM picture';

if(isset($_GET['autor']) || $category != 'index' || isset($_GET['search']) || $_GET['select']){

    $c = 0;
    $query .= ' WHERE';

    if($_GET['select']){
        $user = $_SESSION['login'];

        $query = "SELECT idusers FROM users WHERE login = '$login'";
        $result = mysqli_query($db, $query);
        $userId = mysqli_fetch_row($result);

        $query = "SELECT COUNT(*) FROM selected WHERE iduser = $userId[0]";
        $c = 1;
    }
    if(isset($_GET['autor'])){
        $query .= ' autor = "' . $autor .'"';
        $c = 1;
    }
    if($category != 'index'){
        if($c != 1){
            $query .= ' category = "' . $category . '"';
        }else{
            $query .= ' AND category = "' . $category . '"';
        }
    }
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $search = urldecode($search);
        $querySearch = "SELECT idtag FROM id_nametag WHERE allowed = '1' AND nametag = '$search'";
        $result = mysqli_query($db, $querySearch);
        $idTag1 = mysqli_fetch_row($result);

        $idTag = $idTag1[0];
        $query = "SELECT COUNT(*) FROM id_picturetag WHERE allowed = 1 AND idtag = $idTag";
    }
}
$result = mysqli_query($db, $query);

$posts = mysqli_fetch_row($result);
// Находим общее число страниц
if(isset($_GET['top'])){
    $total = intval(100 / $num + 1);
}else{
    $total = intval((($posts[0] - 1) / $num) + 1);
}
// Определяем начало сообщений для текущей страницы
$page = intval($page);
// Если значение $page меньше единицы или отрицательно
// переходим на первую страницу
// А если слишком большое, то переходим на последнюю
if(empty($page) || $page < 0) $page = 1;
  if($page > $total) $page = $total;
// Вычисляем начиная к какого номера
// следует выводить сообщения
$start = $page * $num - $num;
// Выбираем $num сообщений начиная с номера $start

$query = "SELECT * FROM picture WHERE allowed = '1'";


if($_GET['select']){
    $user = $_SESSION['login'];

    $query = "SELECT idusers FROM users WHERE login = '$login'";
    $result = mysqli_query($db, $query);
    $userId = mysqli_fetch_row($result);

    $query = "SELECT * FROM selected WHERE iduser = $userId[0]";
    $result = mysqli_query($db, $query);
    while ($idPicture[] = mysqli_fetch_array($result));

    $count = count($idPicture)-1;
    $j=$page * $num - $num;
    for ($i = 0; $i < $count; $i++) {
        $query = "SELECT * FROM picture WHERE allowed = '1'";
        if (!empty($idPicture[$j]['idpicture'])) {
            $idPic = $idPicture[$j]['idpicture'];
            $query .= " AND idpicture = $idPic";
            $result = mysqli_query($db, $query);
            $postrow[$i] = mysqli_fetch_array($result);
            $j++;
        }
    }
}elseif(isset($_GET['search'])){

    $search = $_GET['search'];
    $search = urldecode($search);
    $querySearch = "SELECT idtag FROM id_nametag WHERE allowed = '1' AND nametag = '$search'";
    $result = mysqli_query($db, $querySearch);
    $idTag1 = mysqli_fetch_row($result);

    $idTag = $idTag1[0];

    $querySearch = "SELECT * FROM id_picturetag WHERE allowed = '1' AND idtag = '$idTag'";
    $result = mysqli_query($db, $querySearch);
    while ( $idPicture[] = mysqli_fetch_array($result));

    $count = count($idPicture);
    $j=$page * $num - $num;
    for ($i = 0; $i < $count; $i++) {
        $query = "SELECT * FROM picture WHERE allowed = '1'";

        if (!empty($idPicture[$j]['picture'])) {
            $idPic = $idPicture[$j]['picture'];
            $query .= " AND idpicture = $idPic";
            $result = mysqli_query($db, $query);
            $postrow[$i] = mysqli_fetch_array($result);
            $j++;
        }
    }
}elseif(isset($_GET['top'])){

    $query .= " ORDER BY score DESC LIMIT $start, $num ";
    $result = mysqli_query($db, $query);
}else{
    if(isset($_GET['autor'])){

        $query .= " AND autor = " . "'" . $autor . "'";
    }
    if($category != 'index'){

        $query .= " AND category = " . "'" . $category . "'";
    }
    if(isset($_GET['sh'])){

        $sort = $_GET['sh'];
        if(preg_match('/dn/', $sort)){

            $sort = substr($sort, 0, -2);
            $query .= " ORDER BY " . $sort . " ASC LIMIT " . $start . ", " . $num;
        }
        if(preg_match('/up/', $sort)){

            $sort = substr($sort, 0, -2);
            $query .= " ORDER BY " . $sort . " DESC LIMIT " . $start . ", " . $num;
        }
    }else{
        $query .= " ORDER BY data DESC LIMIT " . $start . ", " . $num;
    }
    $result = mysqli_query($db, $query);
}


// В цикле переносим результаты запроса в массив $postrow
if(isset($_GET['top'])){

    while ( $postrow[] = mysqli_fetch_array($result));
    $topLastPage = $num - ($num * $total - 100);
}else{
    while ( $postrow[] = mysqli_fetch_array($result));
}

    for($i = 0; $i<$num; $i++) {
        if (!empty($postrow[$i]['src'])) {
            $src[$i] = 'img/' . $postrow[$i]['category'] . '/mini' . $postrow[$i]['src'];
        }
    }
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

    if(isset($_GET['autor'])){
        echo "<p class='autorName'>Картинки пользователя ".$autor."</p>";
    }elseif($_GET['top']){
        echo "<p class='autorName'>ТОП 100 картинки</p>";
    }elseif($_GET['search']){
        echo '<p class="autorName">Поиск по запросу: "'.$search.'"</p>';
    }

    ?>
    <div class="pictures">
    <?php

    if(isset($_GET['top']) && $page == $total){
        $num = $topLastPage;
    }
        for($i = 0; $i<$num; $i++){
            if(isset($postrow[$i]['src'])){echo '<div class="box">
    <a href="picture.php?img=' . $postrow[$i]['src']. '"><img src="' . $src[$i].'"'.img($postrow[$i]['src']).altTag($postrow[$i]['idpicture']).'></a>
    </div>';}
        }
    ?>
        <div class="pages">
        <?php 

        function pageGener($page, $cat, $class){

            $href = '<a href="./index.php?page='.$page;

            if($cat != 'index'){
                $href .= '&cat='.$cat;
            }
            if(isset($_GET['search'])){
                $search = $_GET['search'];
                $href .= '&search='.$search;
            }
            if(isset($_GET['autor'])) {

                $autor = $_GET['autor'];

                $href .= '&autor='.$autor;
            }
            if(isset($_GET['top'])){
                $href .= '&top=100';
            }
            if(isset($_GET['sh'])){

                $sh = $_GET['sh'];

                $href .= '&sh='.$sh;
            }
            if(!empty($class)){

                $href .= '"'.$class.'>'.$page.'</a>';
            }else{

                $href .= '">'.$page.'</a>';
            }

            return $href;
        }

        if($page<5){
            for($i=1; $i<$page+4; $i++){
                if($i==$page){$class = 'class="disabled"';}
                else{$class='';}
                if($i<=$total and $i!=$total){echo pageGener($i, $category, $class);}
            }
            if($total==$page){$class = 'class="disabled"';}
            if($page<($total-2) and $total>4)echo '<span>... </span>';
            echo pageGener($total, $category, $class);
        
            
        }else if($page>=5 and $page<($total-3)){
            echo pageGener(1, $category, $class);
            echo '<span>... </span>';
            for($i=($page-2); $i<($page+3); $i++){
                if($i==$page){$class = 'class="disabled"';}
                else{$class='';}
                echo pageGener($i, $category, $class);
            }
            echo '<span>... </span>';
            echo pageGener($total, $category, $class);
        
            
        }elseif ($page>=$total-3) {
            if($total>5){
            echo pageGener(1, $category, $class);
            echo '<span>... </span>';
            }
            
            for($i=($total-5); $i<=$total; $i++){
            if($i==0){continue;}
                if($i==$page){$class = 'class="disabled"';}
                else{$class='';}
                if($i<=$total and $i!=$total){echo pageGener($i, $category, $class);}
            }
            echo pageGener($total, $category, $class);
        }  
        ?>
        
        </div>
    </div>