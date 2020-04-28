import { deleteData, postData } from './request.js'


let garbage = document.querySelectorAll('.shopCartProduct-trash');
let less = document.querySelectorAll('.stock-minus');
let more = document.querySelectorAll('.stock-plus');

let product = document.querySelectorAll('.shopCartEntry');

let quantities = document.querySelectorAll('.shopCartProduct-stock span');
let producttotal = document.querySelectorAll('.shopCartProduct-total p');
let productvalue = document.querySelectorAll('.shopCartProduct-per-price ');

for (let i = 0; i < garbage.length; i++) {
    garbage[i].addEventListener('click', async(event) => {

        event.preventDefault();
        let response = await deleteData(garbage[i].href);

        if (response.status != 200)
            return false;
        else
            product[i].remove();


    });

    more[i].addEventListener('click', async(event) => {

        event.preventDefault();
        let response = await postData(more[i].href, 1);

        if (response.status != 200)
            return false;
        else {
            quantities[i].innerHTML = parseInt(quantities[i].innerHTML) + 1;
            producttotal[i].innerHTML = parseInt(quantities[i].innerHTML) * parseInt(productvalue[i].innerText) + "€";
        }


    });

    less[i].addEventListener('click', async(event) => {

        let response
        event.preventDefault();
        if (quantities[i].innerHTML == 1)
            response = await deleteData(garbage[i].href);
        else
            response = await postData(less[i].href, -1);

        if (response.status != 200)
            return false;
        else {
            quantities[i].innerHTML = parseInt(quantities[i].innerHTML) - 1;
            if (quantities[i].innerHTML == 0)
                product[i].remove();
            producttotal[i].innerHTML = parseInt(quantities[i].innerHTML) * parseInt(productvalue[i].innerText) + "€";
        }


    });
}