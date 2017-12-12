
<?php
if(isset($_GET['autor'])){
    $autor = $_GET['autor'];
}
function pageGenerCaterory(){

    $href = '';

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

    return $href;
}
?>

<form action="picturesBox.php" name="category">
<p style="font-weight: 600;"> Катергория:</p>
<a href="index.php?cat=3d<?php echo pageGenerCaterory();?>">3D</a><br>
<a href="index.php?cat=auto<?php echo pageGenerCaterory();?>">Авто</a><br>
<a href="index.php?cat=anime<?php  echo pageGenerCaterory();?>">Аниме</a><br>
<a href="index.php?cat=architecture<?php  echo pageGenerCaterory();?>">Архитектура</a><br>
<a href="index.php?cat=city<?php  echo pageGenerCaterory();?>">Города</a><br>
<a href="index.php?cat=girls<?php  echo pageGenerCaterory();?>">Девушки</a><br>
<a href="index.php?cat=food<?php  echo pageGenerCaterory();?>">Еда</a><br>
<a href="index.php?cat=animals<?php  echo pageGenerCaterory();?>">Животные</a><br>
<a href="index.php?cat=winter<?php  echo pageGenerCaterory();?>">Зима</a><br>
<a href="index.php?cat=game<?php  echo pageGenerCaterory();?>">Игры</a><br>
<a href="index.php?cat=interior<?php  echo pageGenerCaterory();?>">Интерьер</a><br>
<a href="index.php?cat=space<?php  echo pageGenerCaterory();?>">Космос</a><br>
<a href="index.php?cat=cats<?php  echo pageGenerCaterory();?>">Кошки</a><br>
<a href="index.php?cat=creative<?php  echo pageGenerCaterory();?>">Креатив</a><br>
<a href="index.php?cat=love<?php  echo pageGenerCaterory();?>">Любовь</a><br>
<a href="index.php?cat=macro<?php  echo pageGenerCaterory();?>">Макро</a><br>
<a href="index.php?cat=minimalism<?php  echo pageGenerCaterory();?>">Минимализм</a><br>
<a href="index.php?cat=moto<?php  echo pageGenerCaterory();?>">Мото</a><br>
<a href="index.php?cat=man<?php  echo pageGenerCaterory();?>">Мужчины</a><br>
<a href="index.php?cat=music<?php  echo pageGenerCaterory();?>">Музыка</a><br>
<a href="index.php?cat=weapon<?php  echo pageGenerCaterory();?>">Оружие</a><br>
<a href="index.php?cat=nature<?php  echo pageGenerCaterory();?>">Природа</a><br>
<a href="index.php?cat=other<?php  echo pageGenerCaterory();?>">Разное</a><br>
<a href="index.php?cat=sport<?php  echo pageGenerCaterory();?>">Спорт</a><br>
<a href="index.php?cat=texture<?php  echo pageGenerCaterory();?>">Текстуры</a><br>
<a href="index.php?cat=movies<?php  echo pageGenerCaterory();?>">Фильмы</a><br>
<a href="index.php?cat=fantasy<?php  echo pageGenerCaterory();?>">Фэнтези</a><br>
</form>