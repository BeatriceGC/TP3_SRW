
let mode = "signup";

const dataString3 = localStorage.getItem('my-data');
const complexityJSON2 = JSON.parse(dataString3);

console.log("admin");
console.log(complexityJSON2);


function changeWrapper(number) {
    let wrapper = document.getElementsByClassName("wrapper");

    for(let i=0; i<wrapper.length; i++)
    {
        wrapper[i].style.display = "none";
    }
    wrapper[number].style.display = "block";
    wrapper[number].scrollTop = 0;
}



function init_Admin(){
    addEventInput();
    setLastSettingsComplexity();
    setLastSettingsValidity();
    setLastSettingsTry();
}


window.onload = init_Admin