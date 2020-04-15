const picInput = document.querySelector('#img');
const img = document.querySelector('#template-img');

picInput.addEventListener('change', () => {
    if (picInput.files && picInput.files[0]) {
        const reader = new FileReader();

        reader.onload = e => (img.src = e.target.result);

        reader.readAsDataURL(picInput.files[0]);
    }
});