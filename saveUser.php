<?php
header('Content-type: text/html; charset=windows-1251');
include './session.php';

    if(isset($_POST['login'])) 
        {$login = $_POST['login'];
        if($login == ''){unset($login);}
    }
    if(isset($_POST['pass']))
        {$pass = $_POST['pass'];
        if($pass == ''){unset($pass);}
    }
        if(isset($_POST['passCom']))
        {$passCom = $_POST['passCom'];
        if($passCom == ''){unset($passCom);}
    }
        if(isset($_POST['email'])) 
        {$email = $_POST['email'];
        if($email == ''){unset($email);}
    }
    	if (isset($_POST['code'])) 
    	{$code = $_POST['code']; 
    	if($code == ''){ unset($code);}}
    
    if(empty($login) or empty($pass) or empty($email) or empty($code)){
        header('Refresh: 3; URL=http://mydesktopimage.in.ua/registration.php');
        exit("�� ����� �� ��� ����������, ��������� ����� � ��������� "
                . "��� ����!");
    }
    if($pass != $passCom){
        header('Refresh: 3; URL=http://mydesktopimage.in.ua/registration.php');
        exit("��������� ������ �� ���������!");
    }
    if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email)){
        header('Refresh: 3; URL=http://mydesktopimage.in.ua/registration.php');
        exit("������������ e-mail!");
    }
    $login = stripslashes($login);
    $login = trim($login);
    
    $pass = trim($pass);
    $pass = stripslashes($pass);
    $pass = htmlspecialchars($pass);
    
    $pass = md5($pass);
    $pass = strrev($pass);
    
    if(strlen($login) < 3 or strlen($login) > 15) {
        header('Refresh: 3; URL=http://mydesktopimage.in.ua/registration.php');
        exit("����� ������ �������� �� ����� ��� �� 3 �������� � �� "
                . "����� ��� ��    15.".$login);
    }
    if(strlen($password) < 3 or strlen($password) > 15) {
        header('Refresh: 3; URL=http://mydesktopimage.in.ua/registration.php');
        exit("������ ������ �������� �� ����� ��� �� 3 �������� � �� "
                . "����� ��� ��    15.");
    } 
   
    $query = "SELECT idusers FROM users WHERE login='$login'";
    $result = mysqli_query($db,$query)or die("Error" . mysqli_error($db));
    $myrow = mysqli_fetch_array($result);
    if(!empty($myrow ['idusers'])){
        exit ("��������, �������� ���� ����� ��� ���������������. "
                . "������� ������ �����.");
    }
    $queryMail = "SELECT idusers FROM users WHERE usermail='$email'";       
    $resultMail = mysqli_query($db,$queryMail)or die("Error" . mysqli_error($db));
    $myrowMail = mysqli_fetch_array($resultMail);
    if(!empty($myrowMail ['idusers'])){
        exit ("��������, �������� ���� E-mail ��� ���������������. "
                . "������� ������ E-mail.");
    }
    
    
    $query2 = "INSERT INTO users (login,pass,userMail,privileges,datareg) "
            . "VALUES('$login','$pass','$email',1,now())";
    $result2 = mysqli_query($db,$query2);
    echo mysqli_error($db);
    if($result2){
        echo '�� ������� ����������������! ������ �� ������ ����� �� ����.';
        header('Refresh: 1; URL=http://mydesktopimage.in.ua/index.php');
    }else{
        
        echo '������! �� �� ����������������.';
    }
?>