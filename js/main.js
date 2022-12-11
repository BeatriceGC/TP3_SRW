
let mode = "login";

function switchMode() {
    if(mode === "login")
    {
        document.getElementById("switch_span").innerText = "se connecter"
        document.getElementById("validate").value = "S'inscrire";
        document.getElementById("myForm").onsubmit = signUp;
        mode = "signup";
    }
    else if(mode === "signup")
    {
        document.getElementById("switch_span").innerText = "s'inscrire"
        document.getElementById("validate").value = "Se connecter";
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
}


window.onload = init;