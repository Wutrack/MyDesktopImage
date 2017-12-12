<?php
    session_start();
    
    include_once 'session.php';
    
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>Топ 25 пользователей</title> 
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
        <div>
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            <div class="topWrap">
                <h3>Самые активные пользователи:</h3>
            <table class="tableTop">
            <?php
                $query = "SELECT * FROM users ORDER BY score DESC";
                $result = mysqli_query($db, $query);
                while ($users[] = mysqli_fetch_array($result));
                $count = count($users);
                echo '';
                $j=1;
                ?>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>Имя&nbsp;&nbsp;</td>
                <td>Рейтинг&nbsp;&nbsp;</td>
                <td>Группа&nbsp;&nbsp;</td>
                <td>Заргужено&nbsp;&nbsp;</td>
                <td>Скачанно&nbsp;&nbsp;</td>
                <td>Добавлено тегов&nbsp;&nbsp;</td>
                <td>Оценок&nbsp;&nbsp;</td>
                <td>В закладках&nbsp;&nbsp;</td>
                <td>Зарегистрирован&nbsp;&nbsp;</td>
            </tr>
                
                <?php
                for($i = 0;$i<$count; $i++){
                    if(isset($users[$i]['login'])){
                        switch ($users[$i]['privileges']){
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
                        echo '<tr>'
                        . '<td>'.$j++.'</td>'
                        . '<td><a href="office.php?user='.$users[$i]['login'].'">'.$users[$i]['login'].'</a></td>'
                        . '<td>'.$users[$i]['score'].'</td>'
                        . '<td>'.$priv.'</td>'
                        . '<td>'.$users[$i]['upload'].'</td>'
                        . '<td>'.$users[$i]['download'].'</td>'
                        . '<td>'.$users[$i]['addtags'].'</td>'
                        . '<td>'.$users[$i]['setscore'].'</td>'
                        . '<td>'.$users[$i]['bookmarks'].'</td>'
                        . '<td>'.$users[$i]['datareg'].'</td>';
                    }
                }
            ?>
                </table>
            </div>
        </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>