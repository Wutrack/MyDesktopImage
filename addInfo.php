<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}
    
?>
<html>
<head>
    <title>Дополнить информацию</title> 
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
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            <div class="addInfo">
                <form action="addInfoAct.php" method="post" enctype="multipart/form-data" class="addForm">
                    <p>Имя</p>
                    <input type="text" placeholder="Имя" name="name" size="20">
                    <p>Город</p>
                    <input type="text" placeholder="Город" name="city" size="20">
                    <p class="stick">Сменить пароль</p>
                    <p>Старый пароль</p>
                    <input type="password" name="oldpass" size="20">
                    <p>Новый пароль</p>
                    <input type="password" name="newpass" size="20">
                    <p>Новый пароль еще раз</p>
                    <input type="password" name="newpasscon" size="20">
                    <p class="stick">Загрузить аватар</p>
                    <input type="file" size="20" name="fupload">
                    <input type="submit" value="Отправить">
                </form>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>