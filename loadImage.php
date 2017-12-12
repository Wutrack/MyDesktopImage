<?php
    session_start();
    header('Content-type: text/html; charset=windows-1251');
    include_once 'session.php';   
    echo '<datalist id="tags">'; 
    echo '</datalist>';
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    <title>Загрузить картинку</title>
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
                    <h1>Добавление картинки</h1>
                <p class="please">Большая просьба добавлять только лучшие Ваши картинки!</p>
                <p>В форме ниже вы можете добавить Вашу картинку на сайт. После отправки,<br>
                    картинка попадет к модераторам на проверку и если она им понравится - ее добавят на сайт. 
                   <br>Картинки плохого качества, с рекламой, порнографией будут уделены</p><br>
                <p>Требования к загружаемым картинкам:</p>
                <ul>
                    <li>Хорошее качество</li>
                    <li>Картинка должна быть широкоформатной</li>
                    <li>Минимальное разрешение  1280x720. Картинки проверяются при загрузке.</li>
                    <li>Запрещена порнография, хентай</li>
                    <li>Не должно быть никакой рекламы</li>
                    <li>Требуется добавить как минимум 2 тега</li>
                    <li>Теги должны соответствовать картинке.</li>
                    <li>Используйте только русский язык</li>
                </ul>
                    <br>
                <span>Категория:</span>
                </div>
                <form action="loadImageAct.php" method="post" enctype="multipart/form-data" name="fileinfo" class="loadForm">
                    <select name="category">
                        <option></option>
                        <option value="3d">3D</option>
                        <option value="auto">Авто</option>
                        <option value="anime">Аниме</option>
                        <option value="architecture">Архитектура</option>
                        <option value="city">Города</option>
                        <option value="girls">Девушки</option>
                        <option value="food">Еда</option>
                        <option value="animals">Животные</option>
                        <option value="winter">Зима</option>
                        <option value="game">Игры</option>
                        <option value="interior">Интерьер</option>
                        <option value="space">Космос</option>
                        <option value="cats">Кошки</option>
                        <option value="creative">Креатив</option>
                        <option value="love">Любовь</option>
                        <option value="macro">Макро</option>
                        <option value="minimalism">Минимализм</option>
                        <option value="moto">Мото</option>
                        <option value="man">Мужчины</option>
                        <option value="music">Музыка</option>
                        <option value="weapon">Оружие</option>
                        <option value="nature">Природа</option>
                        <option value="other">Разное</option>
                        <option value="sport">Спорт</option>
                        <option value="texture">Текстуры</option>
                        <option value="movies">Фильмы</option>
                        <option value="fantasy">Фэнтези</option>
                    </select><br><br>
                    <input type="file" size="20" name="fupload"><br><br>
                    
                
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