import { deleteData, postData } from './request.js'


let garbage = document.querySelectorAll('.shopCartProduct-trash');
let less = document.querySelectorAll('.stock-minus');
let more = document.querySelectorAll('.stock-plus');
let quantities = document.querySelectorAll('.shopCartProduct-stock span');

for (let i = 0; i < garbage.length; i++) {
    garbage[i].addEventListener('click', async(event) => {

        event.preventDefault();
        let response = await deleteData(garbage[i].href);

        if (response.status != 200)
            return false;
        else
            location.reload();


    });

    more[i].addEventListener('click', async(event) => {

        event.preventDefault();
        let response = await postData(more[i].href, 1);

        if (response.status != 200)
            return false;
        else
            location.reload();


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
        else
            location.reload();


    });
}