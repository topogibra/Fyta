import buildSections from './sections.js'

function createProductColumn(info, attribute) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-2', 'col-6', attribute]);
    column.textContent = info;
    return column;
}

function buildStocks(products){
    const container = document.createElement('div');
    container.className = "container orders";
    const header = document.createElement('div');
    header.className = "row header";

    ['Product', 'Price', 'Stock', 'Delete'].forEach(element => {
        const heading = document.createElement('div');
        heading.className = "col-md-2";
        heading.textContent = element;
        header.appendChild(heading);
    });

    container.appendChild(header);

    products.forEach(product => {
        const row = document.createElement('div');
        row.className = "row";
        row.appendChild(createProductColumn(product.name, 'name'));
        row.appendChild(createProductColumn(product.price, 'price'));
        row.appendChild(createProductColumn(product.stock, 'stock'));
        const icon = document.createElement('i');
        icon.className = "fas fa-plus-circle";
        row.appendChild(icon);
        container.appendChild(row);
    });

    const row = document.createElement('div');
    row.className = "row";
    const col = document.createElement('div');
    col.className = "col-2 ml-auto pr-0";
    const button = document.createElement('a');
    button.className = "btn btn-primary w-100 mt-3";
    button.setAttribute('role', 'button');
    button.textContent = 'Edit';

    return container;
}

const mockProducts = [
    {
        name: 'Orquidea PW',
        price: '20€',
        stock: '20'
    },
    {
        name: 'Orquidea PW',
        price: '20€',
        stock: '20'
    },
];

const managerProfileSections = [
    {
        name: "Stocks",
        action: () => buildStocks(mockProducts)
    },
];


buildSections(managerProfileSections);