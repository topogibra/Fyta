import { deleteProductData } from './request.js'


let garbage = document.querySelector('.shopCartProduct-trash');

garbage.addEventListener('click', async(event) => {

    event.preventDefault();
    let response = await deleteProductData(garbage.href);

    if (response.status != 200)
        return "bananas";



    //TODO:analyze response

});