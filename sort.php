<?php
    $dataPM = 0;

if(isset($_GET['autor'])){
    $autor = $_GET['autor'];
}
?>
<span>����������� ��: </span>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $date?><?php if(!empty($autor)) echo '&autor='.$autor?>">&nbsp;����&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $score?><?php if(!empty($autor)) echo '&autor='.$autor?>">��������&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $looking?><?php if(!empty($autor)) echo '&autor='.$autor?>">���������&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $download?><?php if(!empty($autor)) echo '&autor='.$autor?>">����������&nbsp;|</a>
    <a href="index.php?cat=<?php echo $category?>&sh=<?php echo $bookmarks?><?php if(!empty($autor)) echo '&autor='.$autor?>">���������</a>
