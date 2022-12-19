
const dataString2 = localStorage.getItem('my-data');
const complexityJSON = JSON.parse(dataString2);

let valid = false;
let complexity = "insuffisante";
let complexity_color = "black";


let speciaux = "! \" # $ % & ' ( ) * + , - . / : ; < = > ? @ [ \\ ] ^ _ ` { | } ~".split(" ");
let lettresMaj = "a b c d e f g h i j k l m n o p q r s t u v w x y z".toUpperCase().split(" ");
let chiffres = " 0 1 2 3 4 5 6 7 8 9".split(" ");

let cptMaj;
let cptChiffres;
let cptSpeciaux;
let cptCara;


function UpdateCpt() {
    cptMaj =0
    cptChiffres = 0;
    cptSpeciaux = 0;
    cptCara = 0;

    let entry = document.getElementById("password").value;

    cptCara = entry.length;

    for(let k=0; k<entry.length; k++)
    {
        for(let i=0; i<speciaux.length; i++) if (entry[k] === speciaux[i]) {cptSpeciaux++; break;}
        for(let i=0; i<lettresMaj.length; i++) if (entry[k] === lettresMaj[i]) {cptMaj++; break;}
        for(let i=0; i<chiffres.length; i++) if (entry[k] === chiffres[i]) {cptChiffres++; break;}

    }
}

function UpdateComplexity() {

    if (cptMaj >= complexityJSON.nbMaj[0] && cptChiffres >= complexityJSON.nbChiffres[0] &&                  // Sécurité minimale atteinte
        cptSpeciaux >= complexityJSON.nbSpeciaux[0] && cptCara>= complexityJSON.nbCaracteres[0])
    {
        valid = true;

        if (cptMaj >= complexityJSON.nbMaj[1] && cptChiffres >= complexityJSON.nbChiffres[1] &&              // Sécurité moyenne atteinte
            cptSpeciaux >= complexityJSON.nbSpeciaux[1] && cptCara>= complexityJSON.nbCaracteres[1])
        {
            if (cptMaj >= complexityJSON.nbMaj[2] && cptChiffres >= complexityJSON.nbChiffres[2] &&         // Sécurité maximale atteinte
                cptSpeciaux >= complexityJSON.nbSpeciaux[2] && cptCara>= complexityJSON.nbCaracteres[2])
            {
                complexity = "élevée";
                complexity_color = "green";
            }
            else
            {
                complexity = "moyenne";
                complexity_color = "orange";
            }
        }
        else
        {
            complexity = "faible";
            complexity_color = "red";
        }
    }
    else
    {
        valid = false;
        complexity = "insuffisante";
        complexity_color = "black";
    }

    console.log(complexity)

    document.getElementById("complexity").style.visibility = "visible";
    document.getElementById("complexity_span").innerText = complexity;
    document.getElementById("complexity_div").style.background = complexity_color;
}

function addEventInput(){
    let input = document.getElementById('password');
    input.addEventListener("input", function (event) {
        if(mode === "signup")
        {
            UpdateCpt();
            UpdateComplexity();
        }
    });
}

function updateInputLength() {
    console.log("JSONload");
    console.log(complexityJSON)

    document.getElementById('password').maxLength = complexityJSON.nbCaracteres[2];
    document.getElementById('password2').maxLength = complexityJSON.nbCaracteres[2];
}
