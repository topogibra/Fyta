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
        imgWrapper.href = "product_page.php";
        imgWrapper.className = "img-wrapper";
        const img = document.createElement('img');
        img.className = "card-img-top product-image img-fluid border border-dark";
        img.src = item.img;
        imgWrapper.appendChild(img);
        card.appendChild(imgWrapper);

        const cardBody = document.createElement('div');
        cardBody.className = "card-body text-center";
        const href = document.createElement('a');
        href.href = "product_page.php";
        const heading = document.createElement('h5');
        heading.className = "card-title product-name text-dark";
        heading.textContent = item.name;
        href.appendChild(heading);
        const paragraph = document.createElement('p');
        paragraph.className = "card-text product-price text-secondary";
        paragraph.textContent = img.price;

        cardBody.appendChild(href);
        cardBody.appendChild(paragraph);

        card.appendChild(cardBody);
        row.appendChild(card);
    });
    return container;
}