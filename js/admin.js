
const dataString3 = localStorage.getItem('my-data');
const complexityJSON2 = JSON.parse(dataString3);

console.log("admin");
console.log(complexityJSON2);


function setLastSettings(){
    let spanCara = document.getElementsByClassName("nbCara");
    let nbChiffres = document.getElementsByClassName("nbChiffres");
    let nbSpeciaux = document.getElementsByClassName("nbSpeciaux");
    let nbMaj = document.getElementsByClassName("nbMaj");

    for(let i=0; i<3; i++)
    {
        spanCara[i].value = complexityJSON2.nbCaracteres[i];
        nbChiffres[i].value = complexityJSON2.nbChiffres[i];
        nbSpeciaux[i].value = complexityJSON2.nbSpeciaux[i];
        nbMaj[i].value = complexityJSON2.nbMaj[i];
    }
}

function setNewSettings(){

    let spanCara = document.getElementsByClassName("nbCara");
    let nbChiffres = document.getElementsByClassName("nbChiffres");
    let nbSpeciaux = document.getElementsByClassName("nbSpeciaux");
    let nbMaj = document.getElementsByClassName("nbMaj");

    document.getElementsByClassName("error")[0].style.visibility = "hidden";

    let valid;

    if(parseInt(spanCara[0].value, 10) > parseInt(spanCara[1].value, 10) ||
        parseInt(spanCara[1].value, 10) > parseInt(spanCara[2].value, 10) ||
        parseInt(spanCara[0].value, 10) > parseInt(spanCara[2].value, 10)) valid = false;

    else if(parseInt(nbChiffres[0].value, 10) > parseInt(nbChiffres[1].value, 10) ||
        parseInt(nbChiffres[1].value, 10) > parseInt(nbChiffres[2].value, 10) ||
        parseInt(nbChiffres[0].value, 10) > parseInt(nbChiffres[2].value, 10)) valid = false;

    else if(parseInt(nbSpeciaux[0].value, 10) > parseInt(nbSpeciaux[1].value, 10) ||
        parseInt(nbSpeciaux[1].value, 10) > parseInt(nbSpeciaux[2].value, 10) ||
        parseInt(nbSpeciaux[0].value, 10) > parseInt(nbSpeciaux[2].value, 10)) valid = false;

    else if(parseInt(nbMaj[0].value, 10) > parseInt(nbMaj[1].value, 10) ||
        parseInt(nbMaj[1].value, 10) > parseInt(nbMaj[2].value, 10) ||
        parseInt(nbMaj[0].value, 10) > parseInt(nbMaj[2].value, 10)) valid = false;

    else valid = true;

    if(valid)
    {
        for(let i=0; i<3; i++)
        {
            complexityJSON2.nbCaracteres[i] = spanCara[i].value;
            complexityJSON2.nbChiffres[i] = nbChiffres[i].value;
            complexityJSON2.nbSpeciaux[i] = nbSpeciaux[i].value;
            complexityJSON2.nbMaj[i] = nbMaj[i].value;
        }

        const dataStringReset = JSON.stringify(complexityJSON2);
        localStorage.setItem('my-data', dataStringReset);

        console.log("Settings changed")
        console.log(complexityJSON2);
    }
    else
    {
        document.getElementsByClassName("error")[0].style.visibility = "visible";
    }
}

function init_Admin(){
    setLastSettings();
}


window.onload = init_Admin