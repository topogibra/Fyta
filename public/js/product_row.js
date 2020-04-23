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
        href.href = "/product";
        const heading = document.createElement('h5');
        heading.className = "card-title product-name text-dark";
        heading.textContent = item.name;
        href.appendChild(heading);
        const paragraph = document.createElement('p');
        paragraph.className = "card-text product-price text-secondary";
        paragraph.textContent = item.price + '€ ';
        const addFavorite = document.createElement('i');
        addFavorite.className = "card-link fas fa-star remove-favorite";

        cardBody.appendChild(href);
        paragraph.appendChild(addFavorite);
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