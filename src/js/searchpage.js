let order = document.getElementById('order');
let filter = document.getElementById('filter');


let priceinputmin = document.querySelector(".price .price-inputs .min-input input");
let priceinputmax = document.querySelector(".price .price-inputs .max-input input");
priceinputmin.min = 1
priceinputmin.max = 99
priceinputmax.min = 2
priceinputmax.max = 100

let pricevaluemin = document.querySelector(".price .price-values .min p");
let pricevaluemax = document.querySelector(".price .price-values .max p");

priceinputmin.value = 1;
priceinputmax.value = 100;
let priceinputminoldvalue = 1;
let priceinputmaxoldvalue = 100;


let filtericon = document.querySelector("#filter i")
let filtercontent = document.getElementsByClassName("col-lg-3");


filter.addEventListener('click', (event) => {

    if (filtercontent[0].style.display == "none") {
        filtericon.className = "fas fa-chevron-up";
        filtercontent[0].style.display = "block";
    } else {
        filtericon.className = "fas fa-chevron-down";
        filtercontent[0].style.display = "none";
    }
})

function priceInputHandler() {

    if (priceinputmin.valueAsNumber >= priceinputmax.valueAsNumber) {
        if (priceinputmin.valueAsNumber == priceinputminoldvalue) {
            priceinputmin.value = priceinputmin.valueAsNumber == 1 ? priceinputmin.valueAsNumber : priceinputmin.valueAsNumber - 1
        } else if (priceinputmax.valueAsNumber == priceinputmaxoldvalue) {
            priceinputmax.value = priceinputmax.valueAsNumber == 100 ? priceinputmax.valueAsNumber : priceinputmax.valueAsNumber + 1
        }
    }
    pricevaluemin.innerHTML = priceinputmin.value + "€";
    pricevaluemax.innerHTML = priceinputmax.value + "€";
    priceinputminoldvalue = priceinputmin.valueAsNumber
    priceinputmaxoldvalue = priceinputmax.valueAsNumber


}

priceinputmin.addEventListener('input', priceInputHandler, false);

priceinputmax.addEventListener('input', priceInputHandler, false);