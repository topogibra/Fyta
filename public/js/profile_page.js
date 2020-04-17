import buildProductRow from './product_row.js'
import buildSections from './sections.js'
import buildPersonalInfo from './personal_info.js'
import {fetchData} from './request.js'


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
        const number = document.createElement('div')
        number.classList.add(...['order'])
        number.textContent = order.number
        const href = document.createElement('a');
        href.className = "col-lg-2 col-6";
        href.href = '/profile/order/' + order.id + '/invoice';
        href.appendChild(number);
        orderRow.appendChild(href);
        const date = new Date(order.date);
        const formattedDate = Intl.DateTimeFormat('en-GB').format(date)
        orderRow.appendChild(createOrderColumn(formattedDate, 'date'));
        orderRow.appendChild(createOrderColumn(order.price + '€', 'price'));
        orderRow.appendChild(createOrderColumn(order.state.replace(/_/g," "), 'state'));
        const reOrder = createOrderColumn('', 're-order');
        const icon = document.createElement('div');
        icon.className = "btn btn-primary";
        icon.textContent = "Reorder";
        reOrder.appendChild(icon);
        orderRow.appendChild(reOrder);
        ordersContainer.appendChild(orderRow);
    });

    if(orders.length == 0) {
        const orderRow = document.createElement('div');
        orderRow.classList.add(...['row','justify-content-center','table-entry'])
        orderRow.textContent = 'No orders placed yet.'
        ordersContainer.appendChild(orderRow)
    }

    return ordersContainer;
}


/* const mockOrders = [{
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
]; */

const mockItems = [{
        img: "img/orquideas.jpg",
        name: "Rose Orchid",
        price: "20€"
    },
    {
        img: "img/bonsai2.jpg",
        name: "Bonsai CRT",
        price: "35€"
    },
    {
        img: "img/tulipas.jpg",
        name: "Orange Tulips",
        price: "10€"
    },
    {
        img: "img/vaso.jpg",
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
            photo: 'img/mohammad-faruque-AgYOuy8kA7M-unsplash.jpg'
        }, true)
    },
    {
        name: "Order History",
        action: async () => { 
            const data = await fetchData('/profile/orders');
            return buidOrderHistory(data)
        }
    },
    {
        name: "My Wishlist",
        id: "wishlist",
        action: async () => { 
            const data = await fetchData('/profile/wishlist');
            return buildProductRow(data)
        }
    },
];


buildSections(userProfileSections);
if (window.location.toString().search("#wishlist") != -1) {
    document.querySelector('#wishlist').dispatchEvent(new Event('mousedown'));
}