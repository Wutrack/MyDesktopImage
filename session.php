<?php 

    $host = 'localhost'; // адрес сервера
    $database = 'mydi'; // имя базы данных
    $user = 'Jued'; // имя пользователя
    $password = 'hard1992'; // пароль
    $db = mysqli_connect($host, $user, $password, $database);
    mysqli_query($db, 'SET NAMES cp1251');    
    mysqli_query($db, "SET @@GLOBAL.sql_mode= ''");
    mysqli_query($db, "SET @@SESSION.sql_mode= ''");
    
    if(!empty($_SESSION['login']) and !empty($_SESSION['pass'])){
        $login   = $_SESSION['login'];
        $pass    = $_SESSION['pass'];
        $result  = mysqli_query($db, "SELECT idusers,avatars FROM users WHERE login='$login' AND    pass='$pass'"); 
        $myrow   = mysqli_fetch_array($result);
    }
    ?>