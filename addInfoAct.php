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
                exit('������ ������������ ������!');
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
            exit("������ ������ �������� �� ����� ��� �� 3 �������� � �� "
            . "����� ��� ��    15.");}
        $newpass = md5($newpass);
        $newpass = strrev($newpass);
        $query = "UPDATE users SET pass = '$newpass' WHERE login = '$login'";
        $result1 = mysqli_query($db, $query);
        if($result1){echo '������ ������� ������!';}
        else{ echo '���-�� �� ��� >_>';}
        }else{
        exit('��������� ������ �� ���������!');
        }
    }

    
    $queryUser = "SELECT * FROM users WHERE login = '$login'";
    $resultUser = mysqli_query($db, $queryUser);
    $user = mysqli_fetch_array($resultUser);
    
    if(isset($_POST['name']) and $_POST['name']!=''){
        $querySetName = "UPDATE users SET name = '$name' WHERE login = '$login'";
        $upSetName = mysqli_query($db, $querySetName);
        if($upSetName){echo '��� ������� ���������!';}
        else{ echo '���-�� �� ��� >_>';}
    }
    if(isset($_POST['city']) and $_POST['city']!=''){   
        $querySetCity = "UPDATE users SET city = '$city' WHERE login = '$login'";
        $upSetCity = mysqli_query($db, $querySetCity);
        if($upSetCity){echo '����� ������� ���������!';}
        else{ echo '���-�� �� ��� >_>';}
    }
    
    if(!empty($_POST['fupload'])){
        $fupload=$_POST['fupload'];    $fupload = trim($fupload); 
        if ($fupload =='' or empty($fupload)) {
            unset($fupload);// ���� ���������� $fupload �����, �� ������� ��
        }
    }   
    echo '�������!';     
    
    $size = getimagesize($_FILES['fupload']['tmp_name']);
    if($size[0]<200 or $size[1]<200){
        exit( '� �������� ���������� ���� �����������! �����������: 200�200.');
    }
    
    if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//�������� ������� ��������� �����������
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
                     $im = imagecreatefromgif($target) ; //���� �������� ��� � ������� gif, �� �������    ����������� � ���� �� �������. ���������� ��� ������������ ������
                     }
                     if(preg_match('/[.](PNG)|(png)$/',    $filename)) {
                     $im = imagecreatefrompng($target) ;//����    �������� ��� � ������� png, �� ������� ����������� � ���� �� �������.    ���������� ��� ������������ ������
                     }
                     
                     if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',    $filename)) {
                     $im = imagecreatefromjpeg($target); //���� �������� ��� � ������� jpg, �� ������� ����������� � ���� ��    �������. ���������� ��� ������������ ������
                     }       
            // �������� �������� 90x90
            // dest - �������������� ����������� 
            // w - ������ ����������� 
            // ratio - ����������� ������������������           
$w = 200;  //    ���������� 90x90. ����� ��������� � ������ ������. 
$h = 200;         
// ������ �������� ����������� �� ������ 
            // ��������� ����� � ���������� ��� ������� 
            $w_src    = imagesx($im); //��������� ������
            $h_src    = imagesy($im); //��������� ������ �����������
                     // ������    ������ ���������� �������� 
                     // ����� ������    truecolor!, ����� ����� ����� 8-������ ��������� 
                     $dest = imagecreatetruecolor($w,$w);           
         //    �������� ���������� ��������� �� x, ���� ���� �������������� 
                     if    ($w_src>$h_src) {
                     imagecopyresampled($dest, $im, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2),
                     0, $w, $w,    min($w_src,$h_src), min($w_src,$h_src));  }         
         // ��������    ���������� �������� �� y, 
                     // ���� ����    ������������ (���� ����� ���� ���������) 
                     if   ($w_src<$h_src) {
                     imagecopyresampled($dest, $im, 0, 0,    0, 0, $w, $w,
                     min($w_src,$h_src),    min($w_src,$h_src));   }        
         // ���������� ��������    �������������� ��� ������� 
                     if ($w_src==$h_src) {
                     imagecopyresampled($dest,    $im, 0, 0, 0, 0, $w, $w, $w_src, $h_src);  }         

            imagejpeg($dest, $pathDirectory.$login."mini.jpg");//���������    ����������� ������� jpg � ������ �����, ������ ����� ������� �����. �������,    ����� � �������� �� ���� ���������� ����.          
//������ ������ jpg? �� �������� ����� ���� ����� + ������������    ������������ gif �����������, ������� ��������� ������������. �� �����    ������� ������ ��� �����������, ����� ����� ����� ��������� �����-��    ��������.          
$avatar = $pathDirectory.$login."mini.jpg";//������� � ���������� ���� �� �������. 
            
            $queryAva = "UPDATE users SET avatars = '$avatar' WHERE login = '$login'";
            mysqli_query($db, $queryAva);
            echo '������ �������� �������!';
            
        }else{   
        exit ("�������� ������ ���� � ������� <strong>JPG,GIF ��� PNG</strong>");
        }   
    
    //header('Refresh: 1; URL=http://mydesktopimage.in.ua/office.php');
?>