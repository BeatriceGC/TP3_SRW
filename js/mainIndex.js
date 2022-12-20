
let mode = "login";

function switchMode () {

    console.log(event.target.id)
    if (event.target.id === "switchLog" || event.target.id === "switchLog")
    {
        document.getElementById("wrapperLog").style.display = "grid";
        document.getElementById("wrapperSign").style.display = "none";
        document.getElementById("wrapperForgot").style.display = "none";

        document.getElementById("wrapperLog").onsubmit = logIn;
    }
    else if (event.target.id === "switchSign")
    {
        document.getElementById("wrapperLog").style.display = "none";
        document.getElementById("wrapperSign").style.display = "grid";
        document.getElementById("wrapperForgot").style.display = "none";
        init();
        document.getElementById("wrapperSign").onsubmit = signUp;
    }
    else if (event.target.id === "forgotMdP")
    {
        document.getElementById("wrapperLog").style.display = "none";
        document.getElementById("wrapperSign").style.display = "none";
        document.getElementById("wrapperForgot").style.display = "grid";

        document.getElementById("wrapperForgot").onsubmit = forgotMdP;
    }
}

function logIn() {
    alert("log in !");
}
function signUp() {
    alert("sign up !");
}

function forgotMdP() {
    alert("forgotten MdP !");
}


function init() {
    addEventInput()
    updateInputLength();
}
