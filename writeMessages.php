<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}
    
    
?>
<html>
<head>
    <title>��������</title> 
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
                <form action="writeMessagesAct.php" method="post" class="writeMes">
                    <p>�������� ���������:</p>
                    <p><span>����:</span>
                        <input type="text" size="20" name="receiver" value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>"></p>
                    <p><span>����:</span>
                        <input type="text"size="20" name="theme" value="<?php if(isset($_GET['theme'])){echo $_GET['theme'];}?>"><br></p>
                    <span>���������:</span><br>
                    <textarea rows="10" cols="45" name="message"></textarea><br>
                    <input type="submit" value="���������">
                </form>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>