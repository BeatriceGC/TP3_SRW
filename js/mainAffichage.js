
let mode = "signup";


function changeWrapper(number) {
    let wrapper = document.getElementsByClassName("wrapper");

    for(let i=0; i<wrapper.length; i++)
    {
        wrapper[i].style.display = "none";
    }
    wrapper[number].style.display = "block";
    wrapper[number].scrollTop = 0;
}


function initAffichage() {
    addEventInput();
}

window.onload = initAffichage;