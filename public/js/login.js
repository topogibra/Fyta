import { validateRequirements } from './http_error.js';

let errors;

const page = document.querySelector('#content-wrap #page');
document.getElementById('loginForm').addEventListener('submit', (event) => {

    let validation = ['email', 'password'];
    let validationErrors = validateRequirements(validation);

    errors && errors.remove();
    if (validationErrors) {
        event.preventDefault();
        page.append(validationErrors);
        errors = validationErrors;
    }

});