<?php 
    session_start();
    include './session.php';
    if(isset($_SESSION['login'])){
        $login= $_SESSION['login'];
    }
        if(isset($_POST['name'])) 
        {$name = $_POST['name'];
        if($name == ''){unset($name);}
    }
        if(isset($_POST['city'])) 
        {$city = $_POST['city'];
        if($city == ''){unset($city);}
    }
    
    if(isset($_POST['oldpass'])) 
        {$oldpass = $_POST['oldpass'];
        if($oldpass == ''){unset($oldpass);}
        else{
            $oldpass = md5($oldpass);
            $oldpass = strrev($oldpass);
            if(isset($oldpass) and $oldpass!=$pass){
                exit('Введен неправильный пароль!');
            }
        }
    }
    
    if(isset($_POST['newpass'])) 
        {$newpass = $_POST['newpass'];
        if($newpass == ''){unset($newpass);}
    }
    if(isset($_POST['newpasscon'])) 
        {$newpasscon = $_POST['newpasscon'];
        if($newpasscon == ''){unset($newpasscon);}
    }
    if(isset($newpass) AND isset($newpasscon)){
        if($newpass==$newpasscon){
            if(strlen($newpass) < 3 or strlen($newpass) > 15) {
            exit("Пароль должен состоять не менее чем из 3 символов и не "
            . "более чем из    15.");}
        $newpass = md5($newpass);
        $newpass = strrev($newpass);
        $query = "UPDATE users SET pass = '$newpass' WHERE login = '$login'";
        $result1 = mysqli_query($db, $query);
        if($result1){echo 'Пароль успешно сменен!';}
        else{ echo 'Что-то не так >_>';}
        }else{
        exit('Введенные пароли не совпадают!');
        }
    }

    
    $queryUser = "SELECT * FROM users WHERE login = '$login'";
    $resultUser = mysqli_query($db, $queryUser);
    $user = mysqli_fetch_array($resultUser);
    
    if(isset($_POST['name']) and $_POST['name']!=''){
        $querySetName = "UPDATE users SET name = '$name' WHERE login = '$login'";
        $upSetName = mysqli_query($db, $querySetName);
        if($upSetName){echo 'Имя успешно добавлено!';}
        else{ echo 'Что-то не так >_>';}
    }
    if(isset($_POST['city']) and $_POST['city']!=''){   
        $querySetCity = "UPDATE users SET city = '$city' WHERE login = '$login'";
        $upSetCity = mysqli_query($db, $querySetCity);
        if($upSetCity){echo 'Город успешно добавлено!';}
        else{ echo 'Что-то не так >_>';}
    }
    
    if(!empty($_POST['fupload'])){
        $fupload=$_POST['fupload'];    $fupload = trim($fupload); 
        if ($fupload =='' or empty($fupload)) {
            unset($fupload);// если переменная $fupload пуста, то удаляем ее
        }
    }   
    echo 'успешно!';     
    
    $size = getimagesize($_FILES['fupload']['tmp_name']);
    if($size[0]<200 or $size[1]<200){
        exit( 'У картинки разрешение ниже допустимого! Минимальное: 200х200.');
    }
    
    if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//проверка формата исходного изображения
        {                   
        $filename = $_FILES['fupload']['name'];
        $source = $_FILES['fupload']['tmp_name'];          
        $pathDirectory = 'avatars/';
        $target = $pathDirectory . $login .'.jpg';
        $search = $pathDirectory . $login.'mini.jpg';
                $queryFilename = "SELECT login FROM users WHERE avatars='$search'";
                $rusultFilename = mysqli_query($db, $queryFilename)or die("Error" . mysqli_error($db));
                $rusultFn = mysqli_num_rows($rusultFilename);
                if($rusultFn == 1){
                    unlink($search);
                    unlink($target);
                }
        move_uploaded_file($source, $target);
       	             if(preg_match('/[.](GIF)|(gif)$/',    $filename)) {
                     $im = imagecreatefromgif($target) ; //если оригинал был в формате gif, то создаем    изображение в этом же формате. Необходимо для последующего сжатия
                     }
                     if(preg_match('/[.](PNG)|(png)$/',    $filename)) {
                     $im = imagecreatefrompng($target) ;//если    оригинал был в формате png, то создаем изображение в этом же формате.    Необходимо для последующего сжатия
                     }
                     
                     if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
                     $im = imagecreatefromjpeg($target); //если оригинал был в формате jpg, то создаем изображение в этом же    формате. Необходимо для последующего сжатия
                     }       
            // Создание квадрата 90x90
            // dest - результирующее изображение 
            // w - ширина изображения 
            // ratio - коэффициент пропорциональности           
$w = 200;  //    квадратная 90x90. Можно поставить и другой размер. 
$h = 200;         
// создаём исходное изображение на основе 
            // исходного файла и определяем его размеры 
            $w_src    = imagesx($im); //вычисляем ширину
            $h_src    = imagesy($im); //вычисляем высоту изображения
                     // создаём    пустую квадратную картинку 
                     // важно именно    truecolor!, иначе будем иметь 8-битный результат 
                     $dest = imagecreatetruecolor($w,$w);           
         //    вырезаем квадратную серединку по x, если фото горизонтальное 
                     if    ($w_src>$h_src) {
                     imagecopyresampled($dest, $im, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                     0, $w, $w,    min($w_src,$h_src), min($w_src,$h_src));  }         
         // вырезаем    квадратную верхушку по y, 
                     // если фото    вертикальное (хотя можно тоже серединку) 
                     if   ($w_src<$h_src) {
                     imagecopyresampled($dest, $im, 0, 0,    0, 0, $w, $w,
                     min($w_src,$h_src),    min($w_src,$h_src));   }        
         // квадратная картинка    масштабируется без вырезок 
                     if ($w_src==$h_src) {
                     imagecopyresampled($dest,    $im, 0, 0, 0, 0, $w, $w, $w_src, $h_src);  }         

            imagejpeg($dest, $pathDirectory.$login."mini.jpg");//сохраняем    изображение формата jpg в нужную папку, именем будет текущее время. Сделано,    чтобы у аватаров не было одинаковых имен.          
//почему именно jpg? Он занимает очень мало места + уничтожается    анимирование gif изображения, которое отвлекает пользователя. Не очень    приятно читать его комментарий, когда краем глаза замечаешь какое-то    движение.          
$avatar = $pathDirectory.$login."mini.jpg";//заносим в переменную путь до аватара. 
            
            $queryAva = "UPDATE users SET avatars = '$avatar' WHERE login = '$login'";
            mysqli_query($db, $queryAva);
            echo 'Данные изменены успешно!';
            
        }else{   
        exit ("Картинка должна быть в формате <strong>JPG,GIF или PNG</strong>");
        }   
    
    //header('Refresh: 1; URL=http://mydesktopimage.in.ua/office.php');
?>