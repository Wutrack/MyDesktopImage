<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}
    $id = $_GET['id'];
    
    $queryMes = "SELECT * FROM messages WHERE id = '$id'";
    $resultMes = mysqli_query($db, $queryMes);
    $mes[] = mysqli_fetch_array($resultMes);

    mysqli_query($db, "UPDATE messages SET new = 0 WHERE id = '$id'");
?>
<html>
<head>
    <title>���������</title> 
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
                    <span>���������</span><br>
                    <a href="mesIn.php">��������</a>&nbsp;&nbsp;&nbsp;
                    <a href="mesOut.php">���������</a>&nbsp;&nbsp;&nbsp;
                    <a href="writeMessages.php">��������</a><br>
                </div>
                <form action="writeMessages.php?to=<?php echo $mes[0]['author'].'&theme='.$mes[0]['theme'] ?>" method="post" class="writeMes">
                    <?php

                    echo'<p><span> ����: '.$mes[0]["theme"].'</span></p>';

                    if($_GET['dir'] == 'in'){
                        echo "<p><span>�������� ��: ".$mes[0]['author']."</span></p>";
                    }elseif($_GET['dir'] == 'out'){
                        echo "<p><span>���������� �: ".$mes[0]['receiver']."</span></p>";
                    };
                    echo '<p><span>����: '.$mes[0]['date'].'</span></p>
                    <span>&nbsp;���������: </span><br>
                    <p><textarea rows="10" cols="45" name="message">'.$mes[0]['message'].'</textarea></p>
                    <input type="submit" value="��������">';
                    ?>
                </form>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>