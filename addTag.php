<?php
    session_start();
    header("Content-Type: text/html; charset=Windows-1251");

    $id = $_GET['id'];
    include_once 'session.php';
?>
<html>
<head>
    <title>Добавить тег</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
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

                <form action="addTagAct.php" method="post" enctype="multipart/form-data" name="fileinfo"  class="loadFormTag loadForm">
                    <h1>Добавить тег:</h1>

                    <span>Теги разделять запятой и пробелом (", ") :</span><br>
                    <input type="text" name="tag"  id="tag" list="tags" size="70px" onkeyup="tagsOption(this.value)"><br><br>

                    <div id="forTags"></div>

                    <input  type="submit" value="Загрузить" class="buttonLoad">
                    
                    
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
        oReq.open("POST", "addTagAct.php?id=<?php echo $id?>", true);
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