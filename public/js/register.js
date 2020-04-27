import { validateRequirements } from './http_error.js';

const picInput = document.querySelector('#img');
const img = document.querySelector('#user-img');
const page = document.querySelector('#content-wrap #page');
let errors;
picInput.addEventListener('change', () => {
    if (picInput.files && picInput.files[0]) {
        const reader = new FileReader();

        reader.onload = e => (img.src = e.target.result);

        reader.readAsDataURL(picInput.files[0]);
    }
});

document.getElementById('registerForm').addEventListener('submit', (event) => {

    const form = event.target;
    const day = document.getElementById('day').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    const birthday = year + '-' + month + '-' + day;
    form.birthday.value = birthday;

    let validation = ['username', 'email', 'address', 'birthday', 'password'];
    let validationErrors = validateRequirements(validation);

    errors && errors.remove();
    if (validationErrors) {
        page.append(validationErrors);
        errors = validationErrors;
        event.preventDefault();
    }

});