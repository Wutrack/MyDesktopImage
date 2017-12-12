<?php
    session_start();
    header('Content-type: text/html; charset=windows-1251');
    include_once 'session.php';   
    echo '<datalist id="tags">'; 
    echo '</datalist>';
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>��������� ��������</title>
    <link href="css/picture.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.1.0.js"></script> 
</head>
<body>
    <div class="mainDiv">
        <div class="title">
            <?php
            if(!isset($myrow['idusers'])){
                include 'navNotLogin.php';
            }else{
                include 'navYesLogin.php';}
            ?>
        </div>
            <div class="aNav">
                <?php include_once 'navCategory.php';?>
            </div>
            <div class="load">
                <div class="divDescription">
                    <h1>���������� ��������</h1>
                <p class="please">������� ������� ��������� ������ ������ ���� ��������!</p>
                <p>� ����� ���� �� ������ �������� ���� �������� �� ����. ����� ��������,<br>
                    �������� ������� � ����������� �� �������� � ���� ��� �� ���������� - �� ������� �� ����. 
                   <br>�������� ������� ��������, � ��������, ������������ ����� �������</p><br>
                <p>���������� � ����������� ���������:</p>
                <ul>
                    <li>������� ��������</li>
                    <li>�������� ������ ���� ���������������</li>
                    <li>����������� ����������  1280x720. �������� ����������� ��� ��������.</li>
                    <li>��������� �����������, ������</li>
                    <li>�� ������ ���� ������� �������</li>
                    <li>��������� �������� ��� ������� 2 ����</li>
                    <li>���� ������ ��������������� ��������.</li>
                    <li>����������� ������ ������� ����</li>
                </ul>
                    <br>
                <span>���������:</span>
                </div>
                <form action="loadImageAct.php" method="post" enctype="multipart/form-data" name="fileinfo" class="loadForm">
                    <select name="category">
                        <option></option>
                        <option value="3d">3D</option>
                        <option value="auto">����</option>
                        <option value="anime">�����</option>
                        <option value="architecture">�����������</option>
                        <option value="city">������</option>
                        <option value="girls">�������</option>
                        <option value="food">���</option>
                        <option value="animals">��������</option>
                        <option value="winter">����</option>
                        <option value="game">����</option>
                        <option value="interior">��������</option>
                        <option value="space">������</option>
                        <option value="cats">�����</option>
                        <option value="creative">�������</option>
                        <option value="love">������</option>
                        <option value="macro">�����</option>
                        <option value="minimalism">����������</option>
                        <option value="moto">����</option>
                        <option value="man">�������</option>
                        <option value="music">������</option>
                        <option value="weapon">������</option>
                        <option value="nature">�������</option>
                        <option value="other">������</option>
                        <option value="sport">�����</option>
                        <option value="texture">��������</option>
                        <option value="movies">������</option>
                        <option value="fantasy">�������</option>
                    </select><br><br>
                    <input type="file" size="20" name="fupload"><br><br>
                    
                
                    <span>���� ��������� ������� � �������� (", ") :</span><br>
                    <input type="text" name="tag"  id="tag" list="tags" size="70px" onkeyup="tagsOption(this.value)"><br><br>

                    <div id="forTags"></div>
                    <input  type="submit" value="���������" class="buttonLoad">
                    
                </form>
                <div id="div"></div>
                <script>

function tagsOption(vall){

    var tag = $("#tag").val();
    var pos = 0;
    for(var i = 0; i<30; i++){
        if(vall.charAt(i) === ','){
            pos = i;
        }
    }
    if(pos>0){
        vall = vall.substr(2+pos);
    }

    var xhr = new XMLHttpRequest();
    if(vall !== ''){
        
        xhr.open("GET", "actions.php?search="+vall,true);
        xhr.onreadystatechange = function (){
            if(xhr.readyState === 4 && xhr.status === 200){
                var optionTags = '';
                var searchQ = JSON.parse(xhr.responseText);
                for(var i=0; i<15; i++){
                    if(i<searchQ.length){
                        optionTags += "<span onclick='addToTag(this.innerHTML)' id='span"+i+"'>"+ searchQ[i] +"</span>";
                    }
                }
                forTags.innerHTML = optionTags;
            }
        };
        xhr.send();
    }
    if(vall === ''){
        forTags.innerHTML = '';
    }

}

function addToTag(spanTag){

    var tag = $("#tag");

    var contInput = tag.val();

    var pos = 0;

    for(var i = 0; i<contInput.length; i++){
        if(contInput.charAt(i) === ','){
            pos = 2+i;
        }
    }
    contInput = contInput.substr(0, pos);
    contInput += spanTag + ", ";

    tag.val(contInput);
    forTags.innerHTML = '';
    tag.focus();
}

var form = document.forms.namedItem("fileinfo");
form.addEventListener('submit', function(ev) {
  var oOutput = document.querySelector("#div"),
      oData = new FormData(form);


  var oReq = new XMLHttpRequest();
  oReq.open("POST", "loadImageAct.php", true);
  oReq.overrideMimeType('text/plain; charset=windows-1251');
  oReq.onload = function(oEvent) {
    if (oReq.status == 200) {
      oOutput.innerHTML = oReq.responseText;
    } else {
      oOutput.innerHTML = "Error " + oReq.status + " occurred when trying to upload your file.<br \/>";
    }
  };
  oReq.send(oData);
  ev.preventDefault();
}, false);
</script>
            </div>
    </div>
<?php include_once './footer.php';?> 
</body>
</html>