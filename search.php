<?php
    include './session.php';
    
    echo '<datalist id="tagsSearch">'; 
    echo '</datalist>';   
?>
<form method="get">
    <span>Поиск: </span>
    <input type="search" list="tagsSearch" size="38px" placeholder="Поиск" class="search" name="search" id="search" onsubmit="searchMe(this.value)">
</form>
<script>
var xhr = new XMLHttpRequest();
search.onkeyup = function (){
    var searchQuery = search.value;
    if(search.value !== ''){
        xhr.open("GET", "actions.php?search="+search.value,true);
        xhr.onreadystatechange = function (){
            if(this.readyState === 4 && this.status === 200){
                var optionTags = '';
                var searchQ = JSON.parse(this.responseText);
                for(var i=0; i<searchQ.length; i++){
                    optionTags += "<option value='"+ searchQ[i] +"'>";
                };
                tagsSearch.innerHTML = optionTags;
            };
        };
        xhr.send();
    };
};
function searchMe(vall) {
    var url = "index.php?search=" + vall;
    location.href = url;
}
</script>