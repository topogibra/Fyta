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
const tagsRow = document.querySelector('#tags-container');



const tagsNodes = document.querySelectorAll('.badge.badge-pill.badge-light');

const createdTags = (Array(...tagsNodes).map(node => node.textContent.trim()));

if(createdTags.length > 0){
    tagsRow.style.display = "flex";
    tagsNodes.forEach((node, index) => {
        node.addEventListener('mousedown', () => {
            node.remove();
            createdTags.splice(index, 1);
        });
    })
}


tagInputs.addEventListener('keypress', (event) => {
    if (event.keyCode == 13 || event.which == 13) {
        const column = document.createElement('div');
        column.className = "badge badge-pill badge-light";
        column.textContent = tagInputs.value;
        tags.appendChild(column);
        createdTags.push(tagInputs.value);

        column.addEventListener('mousedown', () => {
            createdTags.splice(createdTags.indexOf(tagInputs.value), 1);
            column.remove();
        });

        tagInputs.value = "";
        event.preventDefault();
    }
});

const category = document.querySelector('.custom-select');

category.addEventListener('change', () => {
    tagsRow.style.display = "flex";
});


document.querySelector('#product-form').addEventListener('submit', (event) => {
    createdTags.push(category.value);
    event.target.tags.value = createdTags.join(',');
});