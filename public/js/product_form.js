const picInput = document.querySelector('#img');
const img = document.querySelector('#template-img');

picInput.addEventListener('change', () => {
    if (picInput.files && picInput.files[0]) {
        const reader = new FileReader();

        reader.onload = e => (img.src = e.target.result);

        reader.readAsDataURL(picInput.files[0]);
    }
});

const tagInputs = document.querySelector('#tags');
const tags = document.querySelector('#tags-row');


const createdTags = [];

tagInputs.addEventListener('keypress', (event) => {
    if (event.keyCode == 13 || event.which == 13) {
        const column = document.createElement('div');
        column.className = "badge badge-pill badge-light";
        column.textContent = tagInputs.value;
        tags.appendChild(column);
        createdTags.push(tagInputs.value);

        column.addEventListener('mousedown', () => {
            column.remove();
        });

        tagInputs.value = "";
        event.preventDefault();
    }
});

const category = document.querySelector('.custom-select');

category.addEventListener('change', () => {
    const tagsRow = document.querySelector('#tags-container');
    tagsRow.style.display = "flex";
});

let errors;
const page = document.querySelector('#content-wrap');

document.querySelector('form').addEventListener('submit', (event) => {

    // event.preventDefault();
    createdTags.push(category.value);
    event.target.tags.value = createdTags.join(',');

    // let validation = ['name', 'price', 'stock', 'description', 'custom-select', 'template-img'];
    // let validationErrors = validateRequirements(validation);

    // errors && errors.remove();
    // if (validationErrors) {
    //     event.preventDefault();
    //     page.append(validationErrors);
    //     errors = validationErrors;
    // }


});