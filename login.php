<?php
    session_start(); 
    
    include_once 'session.php';
?>
<html>
<head>
    <title>����</title> 
    <link href="css/picture.css" rel="stylesheet">
</head>
<body>
    <div class="mainDiv">
        <div class="title">
            <div class="logo">
                <a href="index.php"><img src="img/logo1.png" class="logoImg" alt="???????? ??? ???????? ?????" title="MyDesktopImage ???????? ??? ???????? ?????"></a>
            </div>
        </div>
        <div>
            <div class="login">
                <form action="enter.php" method="post">
                    <p>�����</p>
                    <input type="text" size="20" name="login" class="logField">
                    <p>������</p>
                    <input type="password" size="20" name="pass" class="passField"><br>
                    <p><input type="checkbox" name="save" value='1'>��������� ����!</p>
                    <input type="submit" value="�����"><br>            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>