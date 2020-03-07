let samedelivery = document.querySelector("#sameradio");
let difdelivery = document.querySelector("#differentradio");

let billingaddress = document.querySelector("#billingaddress");


samedelivery.addEventListener('click', (event) => {
    billingaddress.style.display = 'none';
})

difdelivery.addEventListener('click', (event) => {
    billingaddress.style.display = 'block';
})