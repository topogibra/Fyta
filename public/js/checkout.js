const difdelivery = document.querySelector("#checkout");

const billingaddress = document.querySelector("#billingaddress");

difdelivery.addEventListener('change', () => {
    if (difdelivery.checked) {
        billingaddress.style.display = 'none';
    } else {
        billingaddress.style.display = 'block';
    }
})