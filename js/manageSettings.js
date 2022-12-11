

function setLastSettingsComplexity(){
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
function setLastSettingsValidity() {
    let nbTry = document.getElementsByClassName("nbTry");
    let nbT1 = document.getElementsByClassName("nbT1");

    for(let i=0; i<3; i++) nbT1[i].value = complexityJSON2.tValidity[i];
    nbTry[0].value = complexityJSON2.nbEssaiMax;
}
function setLastSettingsTry() {
    let nbTry = document.getElementsByClassName("nbTry");
    let nbT2 = document.getElementsByClassName("nbT2");

    for(let i=0; i<3; i++) nbT2[i].value = complexityJSON2.tWaiting[i];
    nbTry[1].value = complexityJSON2.nbEssaiSucc;
}



function setNewSettingsComplexity(){

    let spanCara = document.getElementsByClassName("nbCara");
    let nbChiffres = document.getElementsByClassName("nbChiffres");
    let nbSpeciaux = document.getElementsByClassName("nbSpeciaux");
    let nbMaj = document.getElementsByClassName("nbMaj");

    document.getElementsByClassName("error")[0].style.visibility = "hidden";

    let valid;

    if(parseInt(spanCara[0].value, 10) > parseInt(spanCara[1].value, 10) ||
        parseInt(spanCara[1].value, 10) > parseInt(spanCara[2].value, 10) ||
        parseInt(spanCara[0].value, 10) > parseInt(spanCara[2].value, 10)) {valid = false;}

    else if(parseInt(nbChiffres[0].value, 10) > parseInt(nbChiffres[1].value, 10) ||
        parseInt(nbChiffres[1].value, 10) > parseInt(nbChiffres[2].value, 10) ||
        parseInt(nbChiffres[0].value, 10) > parseInt(nbChiffres[2].value, 10)) {valid = false;}

    else if(parseInt(nbSpeciaux[0].value, 10) > parseInt(nbSpeciaux[1].value, 10) ||
        parseInt(nbSpeciaux[1].value, 10) > parseInt(nbSpeciaux[2].value, 10) ||
        parseInt(nbSpeciaux[0].value, 10) > parseInt(nbSpeciaux[2].value, 10)) {valid = false;}

    else if(parseInt(nbMaj[0].value, 10) > parseInt(nbMaj[1].value, 10) ||
        parseInt(nbMaj[1].value, 10) > parseInt(nbMaj[2].value, 10) ||
        parseInt(nbMaj[0].value, 10) > parseInt(nbMaj[2].value, 10)) {valid = false;}

    else {valid = true;}

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

        console.log("Settings Complexity changed")
        console.log(complexityJSON2);
    }
    else
    {
        document.getElementsByClassName("error")[0].style.visibility = "visible";
    }
}
function setNewSettingsValidity() {
    let nbTry = document.getElementsByClassName("nbTry");
    let nbT1 = document.getElementsByClassName("nbT1");

    for(let i=0; i<3; i++) complexityJSON2.tValidity[i] = nbT1[i].value;
    complexityJSON2.nbEssaiMax = nbTry[0].value;

    const dataStringReset = JSON.stringify(complexityJSON2);
    localStorage.setItem('my-data', dataStringReset);

    console.log("Settings Validity changed")
    console.log(complexityJSON2);
}
function setNewSettingsTry() {
    let nbTry = document.getElementsByClassName("nbTry");
    let nbT2 = document.getElementsByClassName("nbT2");

    for(let i=0; i<3; i++) complexityJSON2.tWaiting[i] = nbT2[i].value;
    complexityJSON2.nbEssaiSucc = nbTry[1].value;

    const dataStringReset = JSON.stringify(complexityJSON2);
    localStorage.setItem('my-data', dataStringReset);

    console.log("Settings Try changed")
    console.log(complexityJSON2);
}