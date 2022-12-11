localStorage.clear()

const data = {
    nbMaj : [1, 1, 2],
    nbChiffres : [1, 2, 2],
    nbSpeciaux : [0, 1, 2],
    nbCaracteres : [8.0, 10.0, 12.0],

    nbEssaiMax : 10,
    tValidity : [1, 6, 1],

    nbEssaiSucc : 3,
    tWaiting : [0, 1, 30]
};

const dataString = JSON.stringify(data);

if(localStorage.getItem('my-data') === null)
{
    localStorage.setItem('my-data', dataString);
}

