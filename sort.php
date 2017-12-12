<?php
    $dataPM = 0;

if(isset($_GET['autor'])){
    $autor = $_GET['autor'];
}
?>
<span>Сортировать по: </span>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $date?><?php if(!empty($autor)) echo '&autor='.$autor?>">&nbsp;Дате&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $score?><?php if(!empty($autor)) echo '&autor='.$autor?>">Рейтингу&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $looking?><?php if(!empty($autor)) echo '&autor='.$autor?>">Просмотру&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $download?><?php if(!empty($autor)) echo '&autor='.$autor?>">Скачивании&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $bookmarks?><?php if(!empty($autor)) echo '&autor='.$autor?>">Закладках</a>
