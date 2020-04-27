import { deleteData } from './request.js'


let garbage = document.querySelector('.shopCartProduct-trash');

garbage.addEventListener('click', async(event) => {

    event.preventDefault();
    let response = await deleteData(garbage.href);

    if (response.status != 200)
        return false;
    else
        location.reload();


});