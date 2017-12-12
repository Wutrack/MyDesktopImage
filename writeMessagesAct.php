<?php
    session_start();
    include './session.php';

            if(isset($_POST['receiver'])) 
        {$receiver = $_POST['receiver'];
        if($receiver == ''){unset($receiver);}
    }
            if(isset($_POST['theme'])) 
        {$theme = $_POST['theme'];
        if($theme == ''){unset($theme);}
    }
            if(isset($_POST['message'])) 
        {$message = $_POST['message'];
        if($message == ''){unset($message);}
    

        
    $author = $_SESSION['login'];
    
    $queryAddMessages = "INSERT INTO messages (author, receiver, theme, message, date, new) VALUES ('$author', '$receiver', '$theme', '$message', NOW(), '1')";
    $result = mysqli_query($db, $queryAddMessages);
    echo mysqli_error($db);
    
    if($result){
    echo '��������� ����������!';
    header('Refresh: 1; URL=http://mydesktopimage.in.ua/office.php');
    }else{
        exit('���-�� �� ��� >_>');
    }
        }
    if(isset($_POST['url1']) and isset($_GET['url'])){
        $url1 = $_POST['url1'];
        $url2 = $_GET['url'];
        $message='First: '.$url1.'    Second: '.$url2;
        if(isset($_SESSION['login'])){
            $author = $_SESSION['login'];
            $queryAddMessages = "INSERT INTO messages (author, receiver, theme, message, date, new) "
                    . "VALUES ('$author', 'Jued', 'Repeat', '$message', NOW(), '1')";
        }else{
            $queryAddMessages = "INSERT INTO messages ( receiver, theme, message, date, new) "
                    . "VALUES ('Jued', 'Repeat', '$message', NOW(), '1')";
        }
        $result = mysqli_query($db, $queryAddMessages);
        header('Refresh: 1; URL=http://mydesktopimage.in.ua/index.php');
        exit('������� �� ���������!');
    }
     
    
    if(isset($_POST['src'])){
        echo '1111';
            $url2 = $_POST['src'];
            $fupload=$_POST['fupload'];    
            $fupload = trim($fupload); 
        if ($fupload =='' or empty($fupload)) {
            unset($fupload);// ���� ���������� $fupload �����, �� ������� ��
            exit("�� �� ��������� ��������!");
        }
        
        $size = getimagesize($_FILES['fupload']['tmp_name']);
        if($size[0]<1280 or $size[1]<768){
            exit( '� �������� ���������� ���� �����������');
        }
        
        if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name'])){                 
            $filename = $_FILES['fupload']['name'];
            $source = $_FILES['fupload']['tmp_name'];          
            $pathDirectory = 'img/upNew/';
            $target = $pathDirectory . $filename;
         
                $queryFilename = "SELECT idpicture FROM category WHERE src='$filename'";
                $rusultFilename = mysqli_query($db, $queryFilename)or die("Error" . mysqli_error($db));
                $rusultFn = mysqli_fetch_array($rusultFilename);
                if(!empty($rusultFn['idpicture'])){
                    $filename = '1'.$filename;
            }

                move_uploaded_file($source, $target);
   
                echo '�������� "'.$filename.'" ������� ��������� � ���������� �� ��������!';
            }else{
                echo mysqli_error($db);
                echo '������! ���-�� �� ��� >_>';
            }
            $message='SRC: '.$url2. '////FileName: '.$filename;
        if(isset($_SESSION['login'])){
            $author = $_SESSION['login'];
            $queryAddMessages = "INSERT INTO messages (author, receiver, theme, message, date, new) "
                    . "VALUES ('$author', 'Jued', 'Repeat', '$message', NOW(), '1')";
        }else{
            $queryAddMessages = "INSERT INTO messages ( receiver, theme, message, date, new) "
                    . "VALUES ('Jued', 'Repeat', '$message', NOW(), '1')";
        }
        $result = mysqli_query($db, $queryAddMessages);
        echo '������� �� ���������!';
        header('Refresh: 1; URL=http://mydesktopimage.in.ua/office.php');
            
            
        }     
        
?>