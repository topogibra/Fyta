import { postData } from './request.js'

const addFavorites = document.querySelector('#favorites-add');

addFavorites && addFavorites.addEventListener('mousedown', () => {
    const classList = addFavorites.querySelector('i').classList;
    classList.contains('far') ? classList.add('fas') || classList.remove('far') : classList.add('far') || classList.remove('fas');
});

let addShoppingCart = document.getElementById('addbasket');
let qtity = document.getElementById('numItems');
let value = parseInt(qtity.innerText);
let mytoast = document.getElementById('myToast');

addShoppingCart.addEventListener('click', async(event) => {

    value = parseInt(qtity.innerText);
    event.preventDefault();
    let response = await postData(addShoppingCart.href, value);

    if (response.status == 401)
        window.location.replace('/login');
    else if(response.status == 200){
        $('#myToast').toast({ delay: 3000 });
        $('#myToast').toast('show');
    }
    return false;
});