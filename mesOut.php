<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}

                    
?>
<html>
<head>
    <title>Исходящие</title> 
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
            <div class="messWrap">
                <div class="mesNavigate">
                    <span>Сообщения</span><br>
                    <a href="mesIn.php">Входящие</a>&nbsp;&nbsp;&nbsp;
                    <a href="mesOut.php">Исходящие</a>&nbsp;&nbsp;&nbsp;
                    <a href="writeMessages.php">Написать</a><br>
                </div>
                <div class="messBox">
                    <?php
                    $queryMesIn = "SELECT * FROM messages WHERE author = '$login' ORDER BY date DESC";
                    $resultMesIn = mysqli_query($db, $queryMesIn);
                    while($mesInCount[] = mysqli_fetch_array($resultMesIn));

                    $count = count($mesInCount)-1;
                    $num = 10;
                    $total = intval($count / $num + 1);

                    $page = intval($page);

                    if(empty($page) or $page < 0) $page = 1;
                    if($page > $total) $page = $total;

                    $start = $page * $num - $num;

                    $queryMesIn = "SELECT * FROM messages WHERE author = '$login' ORDER BY date DESC LIMIT $start, $num";
                    $resultMesIn = mysqli_query($db, $queryMesIn);
                    while($mesIn[] = mysqli_fetch_array($resultMesIn));

                    for($i=0; $i<$num; $i++){
                        if(isset($mesIn[$i]['id'])){
                            if($mesIn[$i]['new']==1){ $style = 'font-weight: 600';}
                            else{$style = 'font-weight: 300';}
                            echo '<a href="mesView.php?id='.$mesIn[$i]['id'].'&dir=out"><div class="mes" style="'.$style.'">'.
                                '<span>Кому: '.$mesIn[$i]['receiver'].'</span>&nbsp;'.
                                '<span style="float:right;"> В: '.$mesIn[$i]['date'].'</span>'.
                                '<br><span>Тема: '. $mesIn[$i]['theme'].'</span>'

                                . '</div></a>';
                        }
                    }
                    ?>
                </div>
                <div class="pages">
                    <?php

                    function pageGener($page, $class){

                        $href = '<a href="./mesIn.php?page='.$page;

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
                            if($i<=$total and $i!=$total){echo pageGener($i, $class);}
                        }
                        if($total==$page){$class = 'class="disabled"';}
                        if($page<($total-2) and $total>4)echo '<span>... </span>';
                        echo pageGener($total, $class);


                    }else if($page>=5 and $page<($total-3)){
                        echo pageGener(1,  $class);
                        echo '<span>... </span>';
                        for($i=($page-2); $i<($page+3); $i++){
                            if($i==$page){$class = 'class="disabled"';}
                            else{$class='';}
                            echo pageGener($i, $class);
                        }
                        echo '<span>... </span>';
                        echo pageGener($total, $class);


                    }elseif ($page>=$total-3) {
                        if($total>5){
                            echo pageGener(1, $class);
                            echo '<span>... </span>';
                        }

                        for($i=($total-5); $i<=$total; $i++){
                            if($i==0){continue;}
                            if($i==$page){$class = 'class="disabled"';}
                            else{$class='';}
                            if($i<=$total and $i!=$total){echo pageGener($i, $class);}
                        }
                        echo pageGener($total, $class);
                    }
                    ?>

                </div>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>