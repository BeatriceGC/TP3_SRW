
let mode = "login";

function switchMode() {
    if(mode === "login")
    {
        document.getElementById("switch_span").innerText = "se connecter"
        document.getElementById("validate").value = "S'inscrire";

        document.getElementById("confirm_password").style.display = "grid";
        document.getElementById("divName").style.display = "grid";
        document.getElementById("complexity").style.display = "grid";
        document.getElementById("radioButtons").style.display = "grid";

        document.getElementById("complexity").style.visibility = "hidden";
        document.getElementById("wrapper").style.overflowY = "scroll";

        document.getElementById("myForm").onsubmit = signUp;
        mode = "signup";
    }
    else if(mode === "signup")
    {
        document.getElementById("switch_span").innerText = "s'inscrire"
        document.getElementById("validate").value = "Se connecter";

        document.getElementById("confirm_password").style.display = "none";
        document.getElementById("divName").style.display = "grid";
        document.getElementById("complexity").style.display = "none";
        document.getElementById("radioButtons").style.display = "none";

        document.getElementById("wrapper").style.overflowY = "hidden";

        document.getElementById("myForm").onsubmit = logIn;
        mode = "login";
    }
}

function logIn() {
    alert("log in !");
}
function signUp() {
    alert("sign up !");
}




function init() {
    addEventInput()
    updateInputLength();
}


window.onload = init;