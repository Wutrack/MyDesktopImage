<?php
    session_start();
    
    include_once 'session.php';
    if(!empty($_GET['cat'])){
    $category = $_GET['cat'];}
    else{$category = 'index';}
    
?>
<html>
<head>
    <title>��������� ����������</title> 
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
                    <p>���</p>
                    <input type="text" placeholder="���" name="name" size="20">
                    <p>�����</p>
                    <input type="text" placeholder="�����" name="city" size="20">
                    <p class="stick">������� ������</p>
                    <p>������ ������</p>
                    <input type="password" name="oldpass" size="20">
                    <p>����� ������</p>
                    <input type="password" name="newpass" size="20">
                    <p>����� ������ ��� ���</p>
                    <input type="password" name="newpasscon" size="20">
                    <p class="stick">��������� ������</p>
                    <input type="file" size="20" name="fupload">
                    <input type="submit" value="���������">
                </form>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>