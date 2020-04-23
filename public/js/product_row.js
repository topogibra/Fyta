import { deleteData } from "./request.js";

export default function buildProductRow(items){
    const container = document.createElement('div');
    container.className = 'container';
    const row = document.createElement('div');
    row.className = "row";
    container.appendChild(row);
    items.forEach(item => {
        const card = document.createElement('div');
        card.className = "card product border-0 col-lg-3 col-md-6 col-sm-6";
        const imgWrapper = document.createElement('a');
        imgWrapper.href = "/product/" + item.id;
        imgWrapper.className = "img-wrapper";
        const img = document.createElement('img');
        img.className = "card-img-top product-image img-fluid border border-dark";
        img.src = item.img;
        imgWrapper.appendChild(img);
        card.appendChild(imgWrapper);

        const cardBody = document.createElement('div');
        cardBody.className = "card-body text-center";
        const href = document.createElement('a');
        href.href = "/product/" + item.id;
        const heading = document.createElement('h5');
        heading.className = "card-title product-name text-dark";
        heading.textContent = item.name;
        href.appendChild(heading);
        const paragraph = document.createElement('p');
        paragraph.className = "card-text product-price text-secondary";
        paragraph.textContent = item.price + '€ ';
        const removeFavorite = document.createElement('i');
        removeFavorite.className = "card-link fas fa-star remove-favorite";

        removeFavorite.addEventListener('mousedown', async (event) => {
            const href = event.target.parentNode.parentNode.firstChild.href; 
            const itemid = href.substring(href.lastIndexOf('/') + 1);

            let response = await deleteData('/profile/wishlist/' + itemid);

            if (response.status == 200) {
                card.remove();
            }
        });

        cardBody.appendChild(href);
        paragraph.appendChild(removeFavorite);
        cardBody.appendChild(paragraph);

        card.appendChild(cardBody);
        row.appendChild(card);
    });

    if(items.length == 0) {
        row.className = "row justify-content-center"
        row.textContent = 'No items in your wishlist yet.'
    }
    
    return container;
}