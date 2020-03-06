import { removeAll } from './utils.js'

function createOrderColumn(info, attribute){
    const column = document.createElement('div');
    column.classList.add(...['col-md-2', 'col-6', attribute]);
    column.textContent = info;
    return column;
}

function buidOrderHistory(orders){
    const ordersContainer = document.createElement('div');
    ordersContainer.className = "container orders";
    const ordersHeader = document.createElement('div');
    ordersHeader.className = "row header";
    ['Order #', 'Purchase Date', 'Amount', 'Status', 'Reorder'].forEach(element => {
        const heading = document.createElement('div');
        heading.className = "col-md-2";
        heading.textContent = element;
        ordersHeader.appendChild(heading);
    });

    ordersContainer.appendChild(ordersHeader);

    orders.forEach(order => {
        const orderRow = document.createElement('div');
        orderRow.classList.add(...['row', 'justify-content-between']);
        orderRow.appendChild(createOrderColumn(order.number, 'order'));
        orderRow.appendChild(createOrderColumn(order.date, 'date'));
        orderRow.appendChild(createOrderColumn(order.price, 'price'));
        orderRow.appendChild(createOrderColumn(order.state, 'state'));
        const reOrder = createOrderColumn('', 're-order');
        const icon = document.createElement('i');
        icon.classList.add(...['fas', 'fa-plus-circle']);
        const span = document.createElement('span');
        span.textContent = order.price;
        reOrder.appendChild(icon);
        reOrder.appendChild(span);
        orderRow.appendChild(reOrder);
        ordersContainer.appendChild(orderRow);
    });

    const header = document.createElement('h3');
    header.textContent = "Order History";
    
    const contentContainer = document.querySelector('.profile > .row > .col-md-9');
    removeAll(contentContainer);

    contentContainer.appendChild(header);
    contentContainer.appendChild(ordersContainer);
}

const mockOrders = [
    {
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

// buidOrderHistory(mockOrders);