
//setCookie(1,1,1);
checkCookie();

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
   var coookies = document.cookie = cname + "=" + cvalue + "; " + expires + ";";
   alert(coookies);
}

function getCookie(cname) {
    var name = "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        alert(ca[i]);
        c = c.split("=");
        alert(c);
        alert(c[1]);
    }
    return "";
}

function checkCookie() {
    var user = getCookie();
    if (user != "") {
        alert(user);
    }
}

function logout(){
     var coookies = document.cookie = NULL;

}