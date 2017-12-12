<?php
    include './session.php';

    $filename = $_GET['img'];

    if (!empty($_SESSION['login']) and !empty($_SESSION['pass'])){
        $login = $_SESSION['login'];
        $query = "SELECT * FROM users WHERE login = '$login'";
        $result = mysqli_query($db, $query);
        $userInfo = mysqli_fetch_array($result);
    }
    $queryPic = "SELECT * FROM picture WHERE src = '$filename'";
    $resultPic = mysqli_query($db, $queryPic);
    $pic[] = mysqli_fetch_array($resultPic);

    $upload = $pic[0]['looked'];
    settype($upload, "integer");
    $upload++;
                
    $queryPicAp = "UPDATE picture SET looked = '$upload' WHERE src = '$filename'";
    $resultPicAp = mysqli_query($db, $queryPicAp);
    
    $quary = "SELECT * FROM picture WHERE src = '$filename'";
    $result = mysqli_query($db, $quary);
    $picture[] = mysqli_fetch_array($result);
    
    $catQ = $picture[0]['category'];
    $queryArrows = "SELECT * FROM picture WHERE category = '$catQ'";
    $resultArrows = mysqli_query($db, $queryArrows);
    while ($arrows[] = mysqli_fetch_array($resultArrows));
    
    for($i=0; $i<count($arrows)-1; $i++){
        if($arrows[$i]['src']==$picture[0]['src']){
            if($arrows[0]['src']==$picture[0]['src']){
                $arrowsPrev = $arrows[$i+1]['src'];
                break;
            } 
            if($i == (count($arrows)-2)){
                $arrowsNext = $arrows[$i-1]['src'];
                break;
            }
            if($arrows[$i]['src']==$picture[0]['src']){
                $arrowsPrev = $arrows[$i+1]['src'];
                $arrowsNext = $arrows[$i-1]['src'];
                break;
            }
        }
    }
    
    $src = 'img/'.$picture[0]['category'].'/'.$filename;
    $idPicture = $picture[0]['idpicture'];
    
    $quaryIdTag = "SELECT * FROM id_picturetag WHERE picture = '$idPicture'";
    $resultIdTag = mysqli_query($db, $quaryIdTag);
    echo mysqli_error($db);
    while ($idTag[] = mysqli_fetch_array($resultIdTag));
    
    $width = $picture[0]['width'];
    $height = $picture[0]['height'];

    if(isset($login)){
        $idUserQuery = "SELECT idusers FROM users WHERE login ='$login'";
        $idUserRes = mysqli_query($db, $idUserQuery);
        list($idUser) = mysqli_fetch_row($idUserRes);

        $idPictureQuery = "SELECT idpicture FROM picture WHERE src ='$filename'";
        $idPictureRes = mysqli_query($db, $idPictureQuery);
        list($idPictureS) = mysqli_fetch_row($idPictureRes);

        $idUPquery = "SELECT id FROM selected WHERE iduser ='$idUser' and idpicture='$idPictureS'";
        $idUPRes = mysqli_query($db, $idUPquery);
        list($idS) = mysqli_fetch_row($idUPRes);
    }
    $idpicture = $picture[0]['idpicture'];
?>

<div id="score" class="divPView">
    <div id="selected" class="selected">
    <?php
    if(isset($login)){
        if($idS){
        echo '<a id="unsel"">
            <img src="icon/neizbrannoe.jpg""></a>';
        }else{
            echo '<a id="sel">'.
            '<img src="icon/izbrannoe.jpg"></a>';
        }
    }
    ?>
<script>
    $(document).ready(function(){

        $('#selected').on('click','#sel',function(){
            $.ajax({
                url: "selected.php?img=<?php echo $filename?>",
                cache: false,
                success: function(html){
                    $("#selected").html(html);
                }
            });
        });
        $('#selected').on('click','#unsel',function(){
            $.ajax({
                url: "selected.php?img=<?php echo $filename?>",
                cache: false,
                success: function(html){
                    $("#selected").html(html);
                }
            });
        });
    });
</script>

    </div>
    <span class="spanAutor">Загрузил: <a href="office.php?user=<?php echo $picture[0]['autor'] ?> "><?php echo $picture[0]['autor'];?> </a></span>
    
    <span class="spanTags">Теги:
    <?php   
        $j=0;
        for($i=0; $i<20; $i++){

            if(!empty($idTag[$i]['idtag'])){

                $id = $idTag[$i]['idtag'];
                $quaryTagName = "SELECT nametag FROM id_nametag WHERE idtag = '$id' AND allowed = 1";
                $resultTagName = mysqli_query($db, $quaryTagName);
                $tagName = mysqli_fetch_array($resultTagName);

                if($j==0 && !empty($tagName[0])){
                    echo '<a href="index.php?search='.$tagName[0].'">'. $tagName[0] .'</a>'; $j++;
                }elseif($j!=0 && !empty($tagName[0])){
                    echo ',&nbsp;<a href="index.php?search='.$tagName[0].'">'. $tagName[0] .'</a>';
                }
            }else{
                break;
            }
        }
    ?></span>
    
    <span class="spanData">Загруженно: <?php echo $picture[0]['data'];?></span>

            <div class="divImgPV">
            <?php    
                if(isset($arrowsPrev)){echo '<div class="prevImg"><a href="picture.php?img='.$arrowsPrev.'" class="arrowPrev">'
                    . '<img src="icon/left.png"></a></div>';}
                if(isset($arrowsNext)){echo '<div class="nextImg"><a href="picture.php?img='.$arrowsNext.'" class="arrowNext">'
                    . '<img src="icon/right.ico"></a></div>';}
            ?>            
                <img src=<?php echo $src?> class="imgPV">
            </div>
    
<a href="image.php?img=<?php echo $filename;?>" class="buttonLoad" style="float: right;">Скачать</a>
    <span class="spanLooked"> Просмотрено: <?php echo $picture[0]['looked'];?> &nbsp;| &nbsp;
        Скачано: <?php echo $picture[0]['download'];?> &nbsp;|&nbsp;
        В закладках: <?php echo $picture[0]['bookmarks'];?></span>&nbsp;&nbsp;&nbsp;&nbsp;
    <div id="score1" class="scoreHolder">
        <a id="minus" class="plus"><img src="icon/unlike.png" style="max-height: 18px;"></a>
        <span class="span"><?php echo $picture[0]['score'];?></span>
        <a id="plus" class="minus"><img src="icon/like.png" style="max-height: 18px;"></a>
    </div>
        
    <script>  
        $(document).ready(function(){  
          
            $('#minus').click(function(){ 
                $.ajax({  
                    url: "actions.php?score=minus&id=<?php echo $idpicture; ?>",  
                    cache: false,  
                    success: function(html){  
                        $("#score1").html(html);  
                    }  
                });  
            });  
            $('#plus').click(function(){ 
                $.ajax({  
                    url: "actions.php?score=plus&id=<?php echo $idpicture; ?>",
                    cache: false,  
                    success: function(html){
                        $("#score1").html(html);  
                    }  
                });  
            });  
        });  
    </script>  
    
    <span class="spanRazr"><?php echo 'Разрешение: '.$width.'x'.$height?>&nbsp;&nbsp;&nbsp;</span><br><br>
    <form action="writeMessagesAct.php?url=<?php echo $src; ?>" method="POST" enctype="multipart/form-data">
        <div id="repeat" class="tru">
            <span id="rep" class="rep">Вы также можете добавить свои <a href="addTag.php?id=<?php echo $idpicture;?>">теги</a> или
            указать на <a id="r" style="cursor: pointer;">повтор</a>.</span>
            
        </div>
    </form>
    <script>  
        $(document).ready(function(){  
          
            $('#r').click(function(){ 
                $.ajax({  
                    url: "actions.php?r=1?>",  
                    cache: false,  
                    success: function(html){  
                        $("#repeat").html(html);  
                    }  
                });  
            });  
            $('#upimage').click(function(){ 
                $.ajax({  
                    url: "actions.php?up=1?>",  
                    cache: false,  
                    success: function(html){  
                        $("#repeat").html(html);  
                    }  
                });  
            });  
        });
    </script> 
 
        <div class="picturesView">
                
        <?php
            $i=0;
            for($j=0; $j<5 ;$j++){
                if(isset($idTag[$j]['idtag'])){
                    $id = $idTag[$j]['idtag'];
                    $idPictureResult = mysqli_query($db, "SELECT * FROM id_picturetag WHERE idtag = '$id'");
                    while($idPictureTag[] = mysqli_fetch_array($idPictureResult));
                    $count = count($idPictureTag)-1;

                    $check = TRUE;
                    if($count<5){
                        for($t=0; $t<3 ;$t++){
                            if(isset($idPictureTag[$t]['picture'])){
                                if($picture[0]['idpicture']!=$idPictureTag[$t]['picture']){
                                    if($i==0){
                                        $rand[$i] = $idPictureTag[$t]['picture'];
                                        $i++;
                                        continue;
                                    }
                                    if($i==1 and $idPictureTag[$t]['picture']!=$rand[$i-1]){
                                    	$rand[$i] = $idPictureTag[$t]['picture'];
                                    	$i++;
                                    	continue;
                                    }
                                    if($i==2 and $rand[0]!=$rand[1] and $rand[0]!=$rand[2] and $rand[1]!=$rand[2]){
                                        $rand[$i] = $idPictureTag[$t]['picture'];
                                        $i++;
                                        continue;
                                    }
                                }
                            }
                        }
                        unset($idPictureTag);
                        $countRand = count($rand);
                        switch ($countRand){
                            case 0: $i=0;
                                    continue;
                            case 1: $i=1;
                                    continue;
                            case 2: $i=2;
                                    continue;
                        }
                        if($countRand==3)break;
                    }else{
                        for($i; $i<3 ;$i++){
                            $r = rand(0, ($count-2));
                                $rand[$i] = $idPictureTag[$r]['picture'];
                        }
                        while ($check){
                            if($rand[0]==$rand[1]){
                                $r = rand(0, ($count-2));
                                $rand[1] = $idPictureTag[$r]['picture'];
                            }
                            if($rand[1]==$rand[2]){
                                $r = rand(0, ($count-2));
                                $rand[2] = $idPictureTag[$r]['picture'];
                            }
                            if($rand[0]==$rand[2]){
                                $r = rand(0, ($count-2));
                                $rand[2] = $idPictureTag[$r]['picture'];
                            }
                            if($rand[0]!=$rand[1] and $rand[0]!=$rand[2] and $rand[1]!=$rand[2]){
                                if($picture[0]['idpicture']==$rand[0]){
                                    $r = rand(0, ($count-2));
                                    $rand[0] = $idPictureTag[$r]['picture'];
                                    continue;
                                } 
                                if($picture[0]['idpicture']==$rand[1]){
                                    $r = rand(0, ($count-2));
                                    $rand[1] = $idPictureTag[$r]['picture'];
                                    continue;
                                }
                                if($picture[0]['idpicture']==$rand[2]){
                                    $r = rand(0, ($count-2));
                                    $rand[2] = $idPictureTag[$r]['picture'];
                                    continue;
                                }
                                $check=FALSE;
                            }
                        }
                        break;                    
                    }
                }
            }    
            for($i=0; $i<3;$i++){
                if(isset($rand[$i])){
                    $quary = "SELECT category, src FROM picture WHERE idpicture = '$rand[$i]'";
                    $resultRand = mysqli_query($db, $quary);
                    $randPicture = mysqli_fetch_array($resultRand);
                    $category1 = $randPicture['category'];
                    $filename1 = $randPicture['src'];
                    if(!empty($category1) && $filename1!=$filename){$src = 'img/' . $category1 .'/mini'. $filename1;
                            echo '<div class="boxView">'
                        . '<a href="picture.php?img=' . $filename1. '">'
                        . '<img src=' . $src. ' class="imgView">'
                        . '</a>'
                        . '</div>'; 
                    }
                }
            }

            $aut = $picture[0]['autor'];
        ?>
        </div>
    <div class="admin">
    <?php 
    if (!empty($_SESSION['login']) and !empty($_SESSION['pass'])){
        if($userInfo['privileges']==3 or $userInfo['privileges']==4 or $aut==$_SESSION['login']){
            echo '<div class="adminDiv">';
            echo '<a href="/actions.php?img=' . $filename. '& act=del&author=' . $aut . '">Удалить</a>&nbsp;';
            if($picture[0]['allowed']==0){
                echo '<a href="actions.php?img=' . $filename. '& act=yes&author=' . $aut . '">Подтвердить</a>';
            }
            echo '</div>';
        }
    }    
    ?>
    </div>
</div> 
    


    
    