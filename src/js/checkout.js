let difdelivery = document.querySelector("#checkout");

let billingaddress = document.querySelector("#billingaddress");


difdelivery.addEventListener('click', (event) => {
    if (difdelivery.checked) {
        billingaddress.style.display = 'none';
    } else {
        billingaddress.style.display = 'block';
    }
})