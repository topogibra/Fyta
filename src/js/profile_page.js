import buildProductRow from './product_row.js'
import buildSections from './sections.js'
import buildPersonalInfo from './personal_info.js'

function createOrderColumn(info, attribute) {
    const column = document.createElement('div');
    column.classList.add(...['col-lg-2', 'col-6', attribute]);
    column.textContent = info;
    return column;
}

function buidOrderHistory(orders) {
    const ordersContainer = document.createElement('div');
    ordersContainer.className = "container orders";
    const ordersHeader = document.createElement('div');
    ordersHeader.className = "row header";
    ['Order #', 'Purchase Date', 'Amount', 'Status', 'Reorder'].forEach(element => {
        const heading = document.createElement('div');
        heading.className = "col-lg-2 col-6";
        heading.textContent = element;
        ordersHeader.appendChild(heading);
    });

    ordersContainer.appendChild(ordersHeader);

    orders.forEach(order => {
        const orderRow = document.createElement('div');
        orderRow.classList.add(...['row', 'justify-content-between', 'table-entry']);
        const number = createOrderColumn(order.number, 'order');
        const href = document.createElement('a');
        href.className = "col-lg-2 col-6";
        href.href = 'order_invoice.php';
        href.appendChild(number);
        orderRow.appendChild(href);
        orderRow.appendChild(createOrderColumn(order.date, 'date'));
        orderRow.appendChild(createOrderColumn(order.price, 'price'));
        orderRow.appendChild(createOrderColumn(order.state, 'state'));
        const reOrder = createOrderColumn('', 're-order');
        const icon = document.createElement('div');
        icon.className = "btn btn-primary";
        icon.textContent = "Reorder";
        reOrder.appendChild(icon);
        orderRow.appendChild(reOrder);
        ordersContainer.appendChild(orderRow);
    });

    return ordersContainer;
}


const mockOrders = [{
        number: 125877,
        date: "Dec 24 2019",
        price: "23.45€",
        state: "Processed"
    },
    {
        number: 125877,
        date: "Dec 24 2019",
        price: "23.45€",
        state: "Processed"
    }
];

const mockItems = [{
        img: "../assets/orquideas.jpg",
        name: "Rose Orchid",
        price: "20€"
    },
    {
        img: "../assets/bonsai2.jpg",
        name: "Bonsai CRT",
        price: "35€"
    },
    {
        img: "../assets/tulipas.jpg",
        name: "Orange Tulips",
        price: "10€"
    },
    {
        img: "../assets/vaso.jpg",
        name: "XPR Vase",
        price: "15€"
    }
];

const userProfileSections = [{
        name: "Personal Information",
        action: () => buildPersonalInfo({
            username: 'mohammad.faruque',
            email: 'mohammad.faruque@gmail.com',
            address: 'Marcombe Dr NE, Calgary , Canada',
            day: '29',
            month: 'July',
            year: '1998',
            photo: '../assets/mohammad-faruque-AgYOuy8kA7M-unsplash.jpg'
        }, true)
    },
    {
        name: "Order History",
        action: () => buidOrderHistory(mockOrders)
    },
    {
        name: "My Wishlist",
        id: "wishlist",
        action: () => buildProductRow(mockItems)
    },
];


buildSections(userProfileSections);
if (window.location.toString().search("#wishlist") != -1) {
    document.querySelector('#wishlist').dispatchEvent(new Event('mousedown'));
}