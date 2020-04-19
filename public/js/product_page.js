import { postData } from './request.js'

const addFavorites = document.querySelector('#favorites-add');

addFavorites && addFavorites.addEventListener('mousedown', () => {
    const classList = addFavorites.querySelector('i').classList;
    classList.contains('far') ? classList.add('fas') || classList.remove('far') : classList.add('far') || classList.remove('fas');
});

let addShoppingCart = document.getElementById('addbasket');
let qtity = document.getElementById('numItems');
let value = parseInt(qtity.innerText);


addShoppingCart.addEventListener('click', () => load(event));

async function load(event) {
    value = parseInt(qtity.innerText);
    event.preventDefault();
    await postData(addShoppingCart.href, value);
    $("#myToast").toast({ delay: 3000 });
    $("#myToast").toast('show');
    return false;
}