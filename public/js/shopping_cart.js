import { deleteData, postData } from './request.js'


let garbage = document.querySelector('.shopCartProduct-trash');
let less = document.querySelector('.stock-minus');
let more = document.querySelector('.stock-plus');

garbage.addEventListener('click', async(event) => {

    event.preventDefault();
    let response = await deleteData(garbage.href);

    if (response.status != 200)
        return false;
    else
        location.reload();


});

more.addEventListener('click', async(event) => {

    event.preventDefault();
    let response = await postData(less.href, 1);

    if (response.status != 200)
        return false;
    else
        location.reload();


});

less.addEventListener('click', async(event) => {

    event.preventDefault();
    let response = await postData(less.href, -1);

    if (response.status != 200)
        return false;
    else
        location.reload();


});