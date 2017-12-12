<?php
    
    session_start();
    include_once 'session.php';

?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>�����������</title> 
    <link href="css/picture.css" rel="stylesheet">
    
    <style>
        passTrue{
    border-color: #ff1a1a;
    background-color: red;
}
    </style>
</head>
<body>
    <div class="mainDiv">
        <div class="logo">
            <a href="index.php"><img src="img/logo.png" class="logoImg"></a>
        </div>
        <div class="divNavNoLogin">
            <nav class="navA">
                <?php 
                
                include_once 'navNotLogin.php';?>
            </nav>
        </div>
        <div class="divIntro">
            <p>�� ����� ����� �� ������ ������� �����<br> �������� �������� ���
            ������ �������� �����.<br> � ��� �� �������� ����!</p>
        </div>
        <div>
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            <div class="reg">
                <form action="saveUser.php" method="post" enctype="multipart/form-data">
                    <h1>����������� ������ ������������:</h1>
                    <span>�����</span><br>
                    <input type="text" size="20" maxlength="16" name="login" id="loginRegistration">
                    <div id="loginTrueDiv" style="display: inline;"></div><br><br>
                    <span>������</span><br>
                    <input id="pass" type="password" size="20" maxlength="15" name="pass"><br><br>
                    <span>������������� ������</span><br>
                    <input type="password" size="20" maxlength="15" name="passCom" id="passCom">
                    <div id="passTrueDiv" style="display: inline;"></div><br><br>
                    <span>E-mail</span><br>
                    <input type="text" size="20" name="email" id="emailRegistration">
                    <div id="emailRegDiv" style="display: inline;"></div><br><br>
                    <p>������� ��� � ��������:</p>
                    <p><img src="code/my_codegen.php" ></p>
                    <p><input type="text" name="code"></p>
                    <input type="submit" name="submit" value="�����������">
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/picture.js"></script>
</body>
<?php include_once './footer.php';?> 
</html>