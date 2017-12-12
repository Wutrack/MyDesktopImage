<?php
    session_start();
    
    include_once 'session.php';
    
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>��� 25 �������������</title> 
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
        <div>
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            <div class="topWrap">
                <h3>����� �������� ������������:</h3>
            <table class="tableTop">
            <?php
                $query = "SELECT * FROM users ORDER BY score DESC";
                $result = mysqli_query($db, $query);
                while ($users[] = mysqli_fetch_array($result));
                $count = count($users);
                echo '';
                $j=1;
                ?>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>���&nbsp;&nbsp;</td>
                <td>�������&nbsp;&nbsp;</td>
                <td>������&nbsp;&nbsp;</td>
                <td>���������&nbsp;&nbsp;</td>
                <td>��������&nbsp;&nbsp;</td>
                <td>��������� �����&nbsp;&nbsp;</td>
                <td>������&nbsp;&nbsp;</td>
                <td>� ���������&nbsp;&nbsp;</td>
                <td>���������������&nbsp;&nbsp;</td>
            </tr>
                
                <?php
                for($i = 0;$i<$count; $i++){
                    if(isset($users[$i]['login'])){
                        switch ($users[$i]['privileges']){
            case 1: 
                $priv = '<span style="color:#1C1C1C;">������������</span>';
                break;
            case 2: 
                $priv = '<span style="color:#006400;">��������</span>';
                break;
            case 3: 
                $priv = '<b style="color:#191970;">���������</b>';
                break;
            case 4: 
                $priv = '<b style="color:#8B0000;">�������������</b>';
                break;
        }
                        echo '<tr>'
                        . '<td>'.$j++.'</td>'
                        . '<td><a href="office.php?user='.$users[$i]['login'].'">'.$users[$i]['login'].'</a></td>'
                        . '<td>'.$users[$i]['score'].'</td>'
                        . '<td>'.$priv.'</td>'
                        . '<td>'.$users[$i]['upload'].'</td>'
                        . '<td>'.$users[$i]['download'].'</td>'
                        . '<td>'.$users[$i]['addtags'].'</td>'
                        . '<td>'.$users[$i]['setscore'].'</td>'
                        . '<td>'.$users[$i]['bookmarks'].'</td>'
                        . '<td>'.$users[$i]['datareg'].'</td>';
                    }
                }
            ?>
                </table>
            </div>
        </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>