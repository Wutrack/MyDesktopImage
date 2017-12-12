<?php
header('Content-type: text/html; charset=windows-1251');
session_start();
    include './session.php';
    

    if(isset($_GET['img'])){        
        $filename = $_GET['img'];}
    
    if(isset($_GET['author'])){        
        $author = $_GET['author'];}
    
    if(isset($_GET['act'])){   
        $action = $_GET['act'];
        if($action=='yes'){

            $queryUsers = "SELECT * FROM users WHERE login = '$author'";
            $resultUsers = mysqli_query($db, $queryUsers);
            $users[] = mysqli_fetch_array($resultUsers);

            $upload = $users[0]['upload'];
            settype($upload, "integer");
            $upload++;

            $queryUsersAp = "UPDATE users SET upload = '$upload' WHERE login = '$author'";
            $resultUAp = mysqli_query($db, $queryUsersAp);

            $queryPicture = "UPDATE picture SET allowed ='1' WHERE src = '$filename'";
            $resultPicture = mysqli_query($db, $queryPicture);
            header('Refresh: 0; URL=/allowing.php');
        }   
        if ($action=='del') {
            $queryCat = "SELECT idpicture,category FROM picture WHERE src ='$filename'";
            $resultCat = mysqli_query($db, $queryCat);
            list($id, $cat) = mysqli_fetch_array($resultCat);

            $queryUsers = "SELECT * FROM users WHERE login = '$author'";
            $resultUsers = mysqli_query($db, $queryUsers);
            $users[] = mysqli_fetch_array($resultUsers);
            
            $upload = $users[0]['upload'];
            settype($upload, "integer");
            $upload--;

            $queryUsersAp = "UPDATE users SET upload = '$upload' WHERE login = '$author'";
            $resultUAp = mysqli_query($db, $queryUsersAp);
            
            $source = 'img/'.$cat.'/'.$filename;
            unlink($source);

            $source = 'img/'.$cat.'/mini'.$filename;
            unlink($source);

            $delTagQuery = "DELETE FROM id_picturetag WHERE category = '$id'";
            mysqli_query($db, $delTagQuery);

            $queryPicture = "DELETE FROM picture WHERE src = '$filename'";
            $resultPicture = mysqli_query($db, $queryPicture);

            header('Refresh: 0; URL=allowing.php');
        }
        if($action=='yesTag'){

        }
        if($action=='delTag'){

        }
    }
    if(isset($_GET['score'])){   
        $act = $_GET['score'];
        $id=$_GET['id'];
        $queryScore = "SELECT score FROM picture WHERE idpicture ='$id'";
        $resultScore = mysqli_query($db, $queryScore);
        list($score) = mysqli_fetch_row($resultScore);
        if($act=='plus'){
            $score++;
            $querySetScore = "UPDATE picture SET score ='$score' WHERE idpicture ='$id'";
            $resultSetScore = mysqli_query($db, $querySetScore);
            if(isset($lg)){
                $queryUserScore = "SELECT setscore FROM users WHERE login ='$lg'";
                $resultUserScore = mysqli_query($db, $queryUserScore);
                list($UserScore) = mysqli_fetch_row($resultUserScore);
                $UserScore++;
                mysqli_query($db, "UPDATE users SET setscore = '$UserScore' WHERE login ='$lg'");
            }
            echo '<span class="span">'.$score.'</span>';
        }
        if($act=='minus'){
            $score--;
            $querySetScore = "UPDATE picture SET score ='$score' WHERE idpicture ='$id'";
            $resultSetScore = mysqli_query($db, $querySetScore);
            if(isset($lg)){
                $queryUserScore = "SELECT setscore FROM users WHERE login ='$lg'";
                $resultUserScore = mysqli_query($db, $queryUserScore);
                list($UserScore) = mysqli_fetch_row($resultUserScore);
                $UserScore++;
                mysqli_query($db, "UPDATE users SET setscore = '$UserScore' WHERE login ='$lg'");
            }
            echo '<span class="span">'.$score.'</span>';
        }  
    }
    if(isset($_GET['r'])){
        echo '<span>������� ������ �� ��������: </span>
            <input name="url1" type="text" size="30">  
            <input type="submit" value="���������">';
    } 
    if(isset($_GET['up'])){
        echo '
            <form action="loadImageUP.php?url=<?php echo $src; ?>" 
            method="POST">
            <span>��������� ���� ��������: </span>
            <input type="file" size="20" name="fupload">  
            <input type="submit" value="���������">
            </form>';
        
    } 
if(isset($_GET['loginReg'])){
    $login = $_GET['loginReg'];
    if($login == ""){
        exit("����� �� ������ ���� ������.");
    }
    if(strlen($login)<3){
        exit("����� ������ �������� ������� �� ���� ����.");
    }
    if(strlen($login)>16){
        exit("����� �� ����� ���� ������ 16-�� ����.");
    }
    $idUserQuery = "SELECT login FROM users";
    $idUserRes = mysqli_query($db, $idUserQuery);
    while($loginQuery = mysqli_fetch_array($idUserRes)){
         if($login == $loginQuery['login']){
              exit ("� ��������� ����� �����.");
         }
    }
    echo '����� ��������!';
}

if(isset($_GET['emailReg'])){
    $email = $_GET['emailReg'];
    if($email == ""){
        exit("E-mail �� ����� ���� ������.");
    }
    if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email)){
        exit("������������ e-mail!");
    }
    $idUserQuery = "SELECT userMail FROM users";
    $idUserRes = mysqli_query($db, $idUserQuery);
    while($loginQuery = mysqli_fetch_array($idUserRes)){
         if($email == $loginQuery['userMail']){
              exit ("E-mail ��� ������������!");
         }
    }
}
if(isset($_GET['search'])){
    $searchQ = $_GET['search'];
    $search = '';
    $query = "SELECT * FROM id_nametag WHERE nametag LIKE '".$searchQ."%'";
    $searchResult = mysqli_query($db, $query);
    while($searchRes[] = mysqli_fetch_array($searchResult));
    for($i=0; $i <= count($searchRes)-2; $i++){
        
        if($i==count($searchRes)-2){
            $search = $search.'"'.$searchRes[$i]['nametag'].'"';
            break;
        }
        $search = $search.'"'.$searchRes[$i]['nametag'].'", ';
    }
    $search = "[".$search."]";
    echo $search;
}  
?>