var xhr = new XMLHttpRequest();

//search
function takeSearchArray(){
    var arrayTag = "<? echo $json;?>"; 
    document.getElementById('inp').style.borderColor ="red";
}

function getChar(event) {
  if (event.which == null) { // IE
    if (event.keyCode < 32) return null; // спец. символ
    return String.fromCharCode(event.keyCode)
     document.getElementById('inp').value = 'lol1';
  }

  if (event.which != 0 && event.charCode != 0) { // все кроме IE
    if (event.which < 32) return null; // спец. символ
    return String.fromCharCode(event.which); // остальные
     document.getElementById('inp').value = 'lol2';
  }

  return null; // спец. символ
}
//-------------------Registration-----------------------------

var loginRegistration = document.getElementById('loginRegistration');
var loginTrueDiv = document.getElementById('loginTrueDiv');
loginRegistration.onblur = function (){
    xhr.open("GET", "actions.php?loginReg=" + loginRegistration.value, true);
    xhr.onreadystatechange = function (){
        if(xhr.readyState != 4){
            loginTrueDiv.innerHTML =xhr.responseText;
            if(xhr.responseText.length > 16){
                loginRegistration.style.transition = ".2s";
                loginRegistration.style.borderColor = "#ff1a1a";
            }else{
                loginRegistration.style.transition = ".2s";
                loginRegistration.style.borderColor = "#66ff66";
            }
        }
    }
    xhr.send();
};
loginRegistration.onfocus = function () {
    loginTrueDiv.innerHTML = "";
    loginRegistration.style.transition = ".2s";
    loginRegistration.style.borderColor = "";
}

var passReg = document.getElementById('pass');
var passCom = document.getElementById('passCom');
var passDiv = document.getElementById('passTrueDiv');
passCom.onblur = function (){
    if(passReg.value!=="" && passCom.value!==""){
        if(passReg.value!==passCom.value) {
            passCom.style.transition = ".2s";
            passReg.style.transition = ".2s";
            passCom.style.borderColor = "#ff1a1a";
            passReg.style.borderColor = "#ff1a1a";
            passDiv.innerHTML = "Пароли не совпадают!";
        }else{
            passCom.style.transition = ".2s";
            passReg.style.transition = ".2s";
            passCom.style.borderColor = "#66ff66";
            passReg.style.borderColor = "#66ff66";
            passDiv.innerHTML = "";
        }
    }    
};
passReg.onblur = function (){
    if(passReg.value!=="" && passCom.value!==""){
        if(passReg.value!==passCom.value) {
            passCom.style.transition = ".2s";
            passReg.style.transition = ".2s";
            passCom.style.borderColor = "#ff1a1a";
            passReg.style.borderColor = "#ff1a1a";
            passDiv.innerHTML = "  Пароли не совпадают!";
        }else{
            passCom.style.transition = ".2s";
            passReg.style.transition = ".2s";
            passCom.style.borderColor = "#66ff66";
            passReg.style.borderColor = "#66ff66";
            passDiv.innerHTML = "";
        }   
    }    
};
passCom.onfocus = function (){
    passCom.style.transition = ".2s";
    passReg.style.transition = ".2s";
    passCom.style.borderColor = "";
    passReg.style.borderColor = "";
    passDiv.innerHTML = "";
};
passReg.onfocus = function (){
    passCom.style.transition = ".2s";
    passReg.style.transition = ".2s";
    passCom.style.borderColor = "";
    passReg.style.borderColor = "";
    passDiv.innerHTML = "";
};

var emailReg = document.getElementById('emailRegistration');
var emailDiv = document.getElementById('emailRegDiv');
emailReg.onblur = function (){
    xhr.open("GET", "actions.php?emailReg=" + emailReg.value, true);
    xhr.onreadystatechange = function (){
        if(xhr.readyState != 4){
            emailDiv.innerHTML = xhr.responseText;
            if(xhr.responseText.length > 1){
                emailReg.style.transition = ".2s";
                emailReg.style.borderColor = "#ff1a1a";
            }else{
                emailReg.style.transition = ".2s";
                emailReg.style.borderColor = "#66ff66";
            }
        }
    };
    xhr.send();
};
emailReg.onfocus = function () {
    emailDiv.innerHTML = "";
    emailReg.style.transition = ".2s";
    emailReg.style.borderColor = "";
}