import request, {
    postData,
    deleteData
} from './request.js'
import { validateRequirements } from './http_error.js';

const putFavorite = async(url) => {
    const response = await request({
        url,
        method: 'PUT'
    })
    return response
}


const addFavorites = document.querySelector('#favorites-add');
const ToastDelay = 3000;

const productId = document.URL.substring(document.URL.lastIndexOf('/') + 1);

let page = document.querySelector('.product-section');

addFavorites && addFavorites.addEventListener('mousedown', async(event) => {
    const classList = addFavorites.querySelector('i').classList;
    let isFavorited = classList.contains('far');
    let toastbody = document.querySelector('#favoriteToast > .toast-body');
    toastbody.textContent = 'Product ' + (isFavorited ? 'added to' : 'removed from') + ' favorites wishlist!';

    let responseStatus;

    try {
        let response;
        if (isFavorited) {
            response = await putFavorite('/profile/wishlist/' + productId);
        } else {
            response = await deleteData('/profile/wishlist/' + productId);
        }
        responseStatus = response.status;
    } catch (error) {
        responseStatus = error.status;
    }

    if (responseStatus == 200) {
        isFavorited ? classList.add('fas') || classList.remove('far') : classList.add('far') || classList.remove('fas');

        $('#favoriteToast').toast({
            delay: ToastDelay
        });

        $('#favoriteToast').toast('show');
    }
});

let errors;
let addShoppingCart = document.getElementById('addbasket');
let qtity = document.getElementById('numItems');
if (qtity) {
    let value = parseInt(qtity.innerText);

    addShoppingCart.addEventListener('click', async(event) => {

        value = parseInt(qtity.innerText);
        event.preventDefault();

        let validation = ['numItems']
        validateRequirements(validation)
        let validationErrors = validateRequirements(validation);

        errors && errors.remove();
        if (validationErrors) {
            event.preventDefault();
            page.appendChild(validationErrors);
            errors = validationErrors;
            event.target.tags.value = "";
        }

        let response = await postData(addShoppingCart.href, value);

        if (response.status == 401)
            window.location.replace('/login');
        else if (response.status == 200) {
            $('#myToast').toast({
                delay: ToastDelay
            });
            $('#myToast').toast('show');
        }
        return false;
    });
    let dropvalues = document.querySelectorAll('.dropdown-item');

    for (let i = 0; i < dropvalues.length; i++) {
        dropvalues[i].addEventListener('click', function() {
            document.querySelector('.dropdown-toggle').innerText = dropvalues[i].textContent;
        });
    }
}