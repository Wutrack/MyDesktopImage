<?php
header( 'Refresh: 1; URL=index.php' );
    include './session.php';
    
    session_start();
    
    if(isset($_POST['login'])){
        $login = $_POST['login'];
        if($login == ''){unset($login);}
    }
    if(isset($_POST['pass'])){
        $pass = $_POST['pass'];
        if($pass == ''){unset($pass);}
    }
    if (empty($login) or empty($pass))
    {
        exit ("�� ����� �� ��� ����������, ��������� ����� � ��������� ��� ����!");
    }
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $pass = stripslashes($pass);
    $pass = htmlspecialchars($pass);
    $login = trim($login);
    $pass = trim($pass);
    
    $pass = md5($pass);
    $pass = strrev($pass);
    
    $query = "SELECT * FROM users WHERE login='$login'";
    
    $result = mysqli_query($db, $query);
    
    $myrow = mysqli_fetch_array($result);
    
    if(empty($myrow['pass'])){
       exit ("��������, �������� ���� login ��� ������ ��������."); 
    }else{
        if($myrow['pass']==$pass){
            $_SESSION['login']=$myrow['login']; 
            $_SESSION['pass']=$myrow['pass'];
            $_SESSION['id']=$myrow['idusers'];
            echo "�� ������� ����� �� ����! <a href='index.php'>������� ��������</a>";
            if(isset($_POST['save']) && $_POST['save']==1){
                setcookie("login", $_POST["login"], time()+9999999);
                setcookie("password", $_POST["password"], time()+9999999); 
            }
        }
    else{
        exit ("��������, �������� ���� login ��� ������ ��������.");
    }
    }
?>