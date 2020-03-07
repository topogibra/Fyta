let order = document.getElementById('order');
let filter = document.getElementById('filter');
let pricerange = document.querySelector(".price input");
let pricevalue = document.querySelector(".price label");

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

pricerange.addEventListener('input', function() {
    pricevalue.innerHTML = pricerange.value + "€";

}, false);