import { validateRequirements } from './http_error.js';

const difdelivery = document.querySelector("#checkout");
const billingaddress = document.querySelector("#billingaddress");

difdelivery.addEventListener('change', () => {
    if (difdelivery.checked) {
        billingaddress.style.display = 'none';
    } else {
        billingaddress.style.display = 'block';
    }
})

let errors;
let page = document.querySelector('#content-wrap')

document.querySelector('#form').addEventListener('submit', (event) => {

    let validation = ['deliveryaddress'];
    if (billingaddress.style.display != 'none')
        validation.push(...['billingaddress']);

    let validationErrors = validateRequirements(validation);

    errors && errors.remove();
    if (validationErrors) {
        event.preventDefault();
        page.append(validationErrors);
        errors = validationErrors;
    }

});