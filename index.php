<?php
    session_start();
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta name="yandex-verification" content="fc5a42d324e522b5" />
	<meta name="description" content="Картинки на рабочий стол. Самые лучшие картинки для рабочего стола попадают к нам. Вы можете бесплатно скачать классные картинки. Обои на рабочий стол.">
        <meta name="keywords" content="обои, рабочий стол, ежедневное обновление, качественные, высокого разрешения, скачать" />
        <meta name="robots" content="all" />
    <title>Картинки для рабочего стола, обои для рабочего стола, скачать бесплатно без регистрации</title> 
    <link href="css/picture.css" rel="stylesheet">
</head>
<body>
<?php
    
    include_once 'session.php';
    
    if(!empty($_GET['cat'])){
        $category = $_GET['cat'];
    }else{$category = 'index';}

    if(!isset($_GET['sh'])){
        $date='datadn';
        $score='scoreup';
        $looking='lookedup';
        $download='downloadup';
        $bookmarks='bookmarksup';
    }

    if(isset($_GET['sh'])){
        if($_GET['sh']=='dataup'){
            $date='datadn';
        }else{
            $date='dataup';
        }
    }

    if(isset($_GET['sh'])){
        if($_GET['sh']=='scoreup'){
            $score='scoredn';
        }else{
            $score='scoreup';
        }
    }

    if(isset($_GET['sh'])){
        if($_GET['sh']=='lookedup'){
            $looking='lookeddn';
        }else{
            $looking='lookedup';
        }
    }

    if(isset($_GET['sh'])){
        if($_GET['sh']=='downloadup'){
            $download='downloaddn';
        }else{
            $download='downloadup';
        }
    }

    if(isset($_GET['sh'])){
        if($_GET['sh']=='bookmarksup'){
            $bookmarks='bookmarksdn';
        }else{
            $bookmarks='bookmarksup';
        }
    }
?>
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
        <div class="aNav">
                <?php include_once 'navCategory.php';?>
        </div>
            
                <?php 
                include './picturesBox.php';
                ?>
    </div>

    <?php include_once './footer.php';?> 

</body>
</html>