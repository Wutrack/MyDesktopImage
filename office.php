<?php
    session_start();
    include_once 'session.php';
    $loginOf   = $_SESSION['login'];
    if(isset($_GET['user'])){
        $guest = $_GET['user'];
        $query = "SELECT * FROM users WHERE login = '$guest'";
        $result = mysqli_query($db, $query);
        $userInfo = mysqli_fetch_array($result);
        $loginOf   = $guest;
    }    
    
    
    $query = "SELECT * FROM users WHERE login = '$loginOf   '";
    $result = mysqli_query($db, $query);
    $userInfo = mysqli_fetch_array($result);
    
    $iduser = $userInfo['idusers'];
    $queryBM = "SELECT * FROM selected WHERE iduser = '$iduser'";
    $resultBM = mysqli_query($db, $queryBM);
    $BM = mysqli_num_rows($resultBM);
    
    $queryPicture = "SELECT * FROM picture WHERE autor = '$loginOf   '";
    $resultPicture = mysqli_query($db, $queryPicture);
    while ($picture[] = mysqli_fetch_array($resultPicture));
    
    $queryAllowed = "SELECT allowed FROM picture WHERE allowed = '0'";
    $resultAllowed = mysqli_query($db, $queryAllowed);
    $allowed[] = mysqli_fetch_array($resultAllowed);
    $countAllowed = count($allowed);
    
        switch ($userInfo['privileges']){
            case 1: 
                $priv = '<span style="color:#1C1C1C;">Пользователь</span>';
                break;
            case 2: 
                $priv = '<span style="color:#006400;">Активный</span>';
                break;
            case 3: 
                $priv = '<b style="color:#191970;">Модератор</b>';
                break;
            case 4: 
                $priv = '<b style="color:#8B0000;">Администратор</b>';
                break;
        }
    
    $score = ($userInfo['upload'])+($userInfo['addtags']*0.5)+($userInfo['setscore']*0.1);

    mysqli_query($db, "UPDATE users SET bookmarks = '$BM', score = '$score' WHERE login = '$loginOf'");
    
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title><?php echo $loginOf; ?></title> 
    <link href="css/picture.css" rel="stylesheet">
    <link href="css/office.css" rel="stylesheet">
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
            <div class="loginOffice">
                <div class="divAvatar">
                    <h1><?php echo $loginOf; ?></h1>
                        <img src="<?php
                        $filename = $userInfo['avatars'];
                        if(file_exists($filename)){echo $filename;}
                        else{echo'avatars/no-avatar.jpg';}
                        ?>" class="avatar" alt="avatar">
                    <div class="divInfo">
                        <span><?php echo $userInfo['name'];?></span>
                        <p><img src="icon/face.jpg" style="max-height: 12px;">&nbsp;Имя:</p>
                        <span><?php echo $userInfo['city'];?></span>
                        <p><img src="icon/home.jpg" style="max-height: 12px;">&nbsp;Город:</p>
                        <span><?php echo $userInfo['datareg'];?></span>
                        <p>&nbsp;Дата регистрации:</p>
                        <span><?php echo $userInfo['lastdata'];?></span>
                        <p>&nbsp;Последний онлайн:</p>
                        <span><?php echo $priv;?></span>
                        <p>&nbsp;Звание:</p>
                        <?php
                        if(isset($_SESSION['login'])){
                            $user = $_SESSION['login'];
                            if($loginOf==$user){
                                if($userInfo['privileges']==3 or $userInfo['privileges']==4){
                                    echo '<a href="allowing.php">Подтвердить</a><br>';
                                }
                                echo '<a href="addInfo.php">Изменить данные</a>';
                            }
                        }
                        ?>
                    </div>
                    
                </div>
                <div class="divScore">
                    <span><?php echo $score;?></span>
                    <p><img src="icon/stars.jpg" style="max-height: 15px;">Рейтинг:</p>
                    <span><?php echo $userInfo['upload'];?></span>
                    <p><img src="icon/upload.jpg" style="max-height: 15px;">Загружено картинок:</p>
                    <span><?php echo $userInfo['addtags'];?></span>
                    <p><img src="icon/tags.jpg" style="max-height: 15px;">Добавлено тегов:</p>
                    <span><?php echo $userInfo['setscore'];?></span>
                    <p><img src="icon/ok.jpg" style="max-height: 15px;">Выставлено оценок:</p>
                    <span><?php echo $userInfo['download'];?></span>
                    <p><img src="icon/download.jpg" style="max-height: 15px;">Скачано:</p>
                    <span><?php echo $BM;?></span>
                    <p><img src="icon/bookmarks.jpg" style="max-height: 15px;">Закладок:</p>
                </div>
                <?php 
                if(isset($_SESSION['login'])){
                    if($loginOf==$user){?>

                        <div class="divMessage">
                            <div class="mesNav">
                                <span>Сообщения</span><br>
                                <a href="mesIn.php">Входящие</a>&nbsp;&nbsp;&nbsp;
                                <a href="mesOut.php">Исходящие</a>&nbsp;&nbsp;&nbsp;
                                <a href="writeMessages.php">Написать</a><br>
                            </div>
                            <div class="mesBox">
                        <?php
                            $queryMesIn = "SELECT * FROM messages WHERE receiver = '$loginOf' ORDER BY date DESC";
                            $resultMesIn = mysqli_query($db, $queryMesIn);
                            while($mesIn[] = mysqli_fetch_array($resultMesIn));

                            $queryMesOut = "SELECT * FROM messages WHERE author = '$loginOf' ORDER BY date DESC";
                            $resultMesOut = mysqli_query($db, $queryMesOut);
                            while($mesOut[] = mysqli_fetch_array($resultMesOut));

                            $count = count($mesIn)-1;
                            for($i=0; $i<5; $i++){
                                if(isset($mesIn[$i]['id'])){
                                    if($mesIn[$i]['new']==1){$style = 'font-weight: 600';}
                                    else{$style = 'font-weight: 300';}
                                    echo '<a href="mesView.php?id='.$mesIn[$i]['id'].'"><div class="mes" style="'.$style.'">'.
                                         '<span>От кого: '.$mesIn[$i]['author'].'</span>&nbsp;'.
                                         '<span style="float:right;"> В: '.$mesIn[$i]['date'].'</span>'.
                                         '<br><span>Тема: '. $mesIn[$i]['theme'].'</span>'

                                    . '</div></a>';
                                }
                            }
                        ?>
                            </div>
                        </div>
                        <?php
                    }else{?>
                        <a href="writeMessages.php?to=<?php echo $guest;?>"class="button"><img src="icon/Message-50.png">Написать сообщение!</a>
                    <?php }
                }?>
            </div>
            <div class="divP">
                <p>Картинки пользователя:</p>
            </div>
            <div class="userPic">

            <?php
            $count = count($picture)-1;
            if($count>40){
                $count = 40;
                $many = true;
            }
            for($i=0; $i<$count;$i++){
		        if($picture[$i]['allowed']==1){
	                $category = $picture[$i]['category'];
	                $filename = $picture[$i]['src'];
	                if(!empty($category)){$src = 'img/' . $category .'/mini'. $filename;}

	                    echo '<div class="boxView">'
	                . '<a href="picture.php?img=' . $filename. '">'
	                . '<img src=' . $src. ' class="imgOffice">'
	                . '</a>'
	                        . '</div>';

	         }
            }
            if($many){
                echo '<a <a href="./index.php?autor='.$loginOf.'" class="toUserPic">Показать все картинки пользователя</a>';
            }
            ?>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>