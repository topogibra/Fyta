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

window.addEventListener('resize', (event) => {

    if (window.screen.width > 800) {
        filtercontent[0].style.display = "block";
    }
})

priceinputmin.addEventListener('input', function() {

    if (priceinputmin.valueAsNumber < priceinputmax.valueAsNumber)
        pricevaluemin.innerHTML = priceinputmin.value + "€";
    else {
        priceinputmax.value = priceinputmax.valueAsNumber == 100 ? priceinputmax.valueAsNumber : priceinputmax.valueAsNumber + 1
        priceinputmin.value = priceinputmax.valueAsNumber - 1
        pricevaluemin.innerHTML = priceinputmin.value + "€";
        pricevaluemax.innerHTML = priceinputmax.value + "€";
    }


}, false);

priceinputmax.addEventListener('input', function() {

    if (priceinputmin.valueAsNumber < priceinputmax.valueAsNumber)
        pricevaluemax.innerHTML = priceinputmax.value + "€";
    else {
        priceinputmin.value = priceinputmin.valueAsNumber == 1 ? priceinputmin.valueAsNumber : priceinputmin.valueAsNumber - 1
        priceinputmax.value = priceinputmin.valueAsNumber + 1
        pricevaluemin.innerHTML = priceinputmin.value + "€";
        pricevaluemax.innerHTML = priceinputmax.value + "€";
    }


}, false);