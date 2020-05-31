import {
    deleteData,
    postData
} from './request.js'


let garbage = document.querySelectorAll('.shopCartProduct-trash');
let less = document.querySelectorAll('.stock-minus');
let more = document.querySelectorAll('.stock-plus');

let product = document.querySelectorAll('.shopCartEntry');

let quantities = document.querySelectorAll('.shopCartProduct-stock span');
let producttotal = document.querySelectorAll('.shopCartProduct-total p');
let productvalue = document.querySelectorAll('.shopCartProduct-per-price ');
let totalvalue = document.getElementById("cart-total");

let noproducts = document.querySelector('#noproducts');
let checkout = document.querySelector('#checkout_btn');

if (noproducts) {
    if (product.length != 0)
        noproducts.style.display = 'none'
    else
        noproducts.style.display = 'block'
}

for (let i = 0; i < garbage.length; i++) {
    garbage[i].addEventListener('click', async (event) => {

        event.preventDefault();
        let response = await deleteData(garbage[i].href);

        if (response.status != 200)
            return false;
        else {
            if (totalvalue) {
                totalvalue.innerText = +(parseFloat(totalvalue.innerText) - parseFloat(producttotal[i].innerText)).toFixed(2) + "€";
                if (parseFloat(totalvalue.innerText) == 0) {
                    window.location.replace("/home");
                }
            }
            product[i].remove();
            product = document.querySelectorAll('.shopCartEntry');
            if (product.length == 0) {
                noproducts.style.display = 'block'
                checkout.remove();
            }
        }


    });

    more[i].addEventListener('click', async (event) => {

        event.preventDefault();
        let response = await postData(more[i].href, 1);

        if (response.status != 200)
            return false;
        else {
            quantities[i].innerText = parseInt(quantities[i].innerText) + 1;
            producttotal[i].innerText = +(parseInt(quantities[i].innerText) * parseFloat(productvalue[i].innerText)).toFixed(2) + "€";
            if (totalvalue) {
                totalvalue.innerText = +(parseFloat(totalvalue.innerText) + parseFloat(productvalue[i].innerText)).toFixed(2) + "€";
            }
        }


    });

    less[i].addEventListener('click', async (event) => {

        let response
        event.preventDefault();
        if (quantities[i].innerText == 1)
            response = await deleteData(garbage[i].href);
        else
            response = await postData(less[i].href, -1);

        if (response.status != 200)
            return false;
        else {
            quantities[i].innerText = parseInt(quantities[i].innerText) - 1;
            if (totalvalue) {
                totalvalue.innerText = +(parseFloat(totalvalue.innerText) - parseFloat(productvalue[i].innerText)).toFixed(2)+ "€";
                if (parseFloat(totalvalue.innerText) == 0) {
                    window.location.replace("/home");
                }
            }
            if (quantities[i].innerText == 0) {
                product[i].remove();
                product = document.querySelectorAll('.shopCartEntry');
                if (product.length == 0) {
                    noproducts.style.display = 'block'
                    checkout.remove();
                }
            }
            producttotal[i].innerText = +(parseInt(quantities[i].innerText) * parseFloat(productvalue[i].innerText)).toFixed(2) + "€";

        }


    });
}