
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
<p style="font-weight: 600;"> ����������:</p>
<a href="index.php?cat=3d<?php echo pageGenerCaterory();?>">3D</a><br>
<a href="index.php?cat=auto<?php echo pageGenerCaterory();?>">����</a><br>
<a href="index.php?cat=anime<?php  echo pageGenerCaterory();?>">�����</a><br>
<a href="index.php?cat=architecture<?php  echo pageGenerCaterory();?>">�����������</a><br>
<a href="index.php?cat=city<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=girls<?php  echo pageGenerCaterory();?>">�������</a><br>
<a href="index.php?cat=food<?php  echo pageGenerCaterory();?>">���</a><br>
<a href="index.php?cat=animals<?php  echo pageGenerCaterory();?>">��������</a><br>
<a href="index.php?cat=winter<?php  echo pageGenerCaterory();?>">����</a><br>
<a href="index.php?cat=game<?php  echo pageGenerCaterory();?>">����</a><br>
<a href="index.php?cat=interior<?php  echo pageGenerCaterory();?>">��������</a><br>
<a href="index.php?cat=space<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=cats<?php  echo pageGenerCaterory();?>">�����</a><br>
<a href="index.php?cat=creative<?php  echo pageGenerCaterory();?>">�������</a><br>
<a href="index.php?cat=love<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=macro<?php  echo pageGenerCaterory();?>">�����</a><br>
<a href="index.php?cat=minimalism<?php  echo pageGenerCaterory();?>">����������</a><br>
<a href="index.php?cat=moto<?php  echo pageGenerCaterory();?>">����</a><br>
<a href="index.php?cat=man<?php  echo pageGenerCaterory();?>">�������</a><br>
<a href="index.php?cat=music<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=weapon<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=nature<?php  echo pageGenerCaterory();?>">�������</a><br>
<a href="index.php?cat=other<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=sport<?php  echo pageGenerCaterory();?>">�����</a><br>
<a href="index.php?cat=texture<?php  echo pageGenerCaterory();?>">��������</a><br>
<a href="index.php?cat=movies<?php  echo pageGenerCaterory();?>">������</a><br>
<a href="index.php?cat=fantasy<?php  echo pageGenerCaterory();?>">�������</a><br>
</form>