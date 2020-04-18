import buildSections from './sections.js';
import buildPersonalInfo from './personal_info.js';
import { buildPersonalInfoForm } from './personal_info.js';
import { fetchData } from './request.js'
import { buildErrorMessage } from './http_error.js';



function createProductColumn(info, attribute) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-3', 'col-6', attribute]);
    column.textContent = info;
    return column;
}

const stateStatus = {
    'Ready for Shipping': 'Confirm  Shipping',
    'Awaiting Payment': 'Awaiting Payment'
}

function buildStocks(products) {
    const container = document.createElement('div');
    container.className = "container";
    const header = document.createElement('div');
    header.className = "row header";

    ['Product', 'Price', 'Stock', 'Delete'].forEach(element => {
        const heading = document.createElement('div');
        heading.className = "col-md-3";
        heading.textContent = element;
        header.appendChild(heading);
    });

    container.appendChild(header);

    products.forEach(product => {
        const row = document.createElement('div');
        row.className = "row table-entry";
        const name = createProductColumn(product.name, 'name');
        const href = document.createElement('a');
        href.href = '/product/' + product.id;
        href.appendChild(name);
        href.className = "col-md-3 col-6 name";
        row.appendChild(href);
        row.appendChild(createProductColumn(product.price, 'price'));
        row.appendChild(createProductColumn(product.stock, 'stock'));
        const col = createProductColumn('', 'delete');
        const icon = document.createElement('i');
        icon.className = "fas fa-trash";
        col.appendChild(icon);
        row.appendChild(col);
        container.appendChild(row);
    });

    const row = document.createElement('div');
    row.className = "row";
    const col = document.createElement('div');
    col.className = "col-md-4 col-12 ml-auto mr-0 pr-0";
    const button = document.createElement('a');
    button.className = "btn rounded-0 btn-lg shadow-none";
    button.setAttribute('role', 'button');
    button.textContent = 'Edit';
    button.id = "products-button"
    col.appendChild(button);
    row.appendChild(col);
    container.appendChild(row);

    const changeMode = (nodeCreation) => {
        ['name', 'price'].forEach(elementClass => {
            const elements = document.querySelectorAll(`.${elementClass}`);
            elements.forEach(element => element.replaceWith(nodeCreation(element)));
        });
    }
    col.addEventListener('mousedown', () => {
        if (button.classList.contains('edit')) {
            button.classList.remove('edit');
            button.classList.add('changes');
            button.textContent = "Save Changes"
            const generateInputNode = element => {
                const node = document.createElement('input');
                node.className = element.className;
                node.type = 'text';
                node.value = element.textContent;
                return node;
            };
            changeMode(generateInputNode);
            document.querySelectorAll('.stock').forEach(stock => {
                const input = generateInputNode(stock);
                input.className = "stock";
                const minus = document.createElement('i');
                minus.className = "far fa-minus-square";
                input.before(minus);
                const plus = document.createElement('i');
                plus.className = "far fa-plus-square";
                input.after(plus);
                minus.addEventListener('mousedown', () => stock.value = Number(stock.value) - 1);
                plus.addEventListener('mousedown', () => stock.value = Number(stock.value) + 1);
                const wrapper = document.createElement('div');
                wrapper.className = stock.className;
                wrapper.classList.add('stock-wrapper')
                wrapper.appendChild(minus);
                wrapper.appendChild(input);
                wrapper.appendChild(plus);
                stock.replaceWith(wrapper);
            });

        } else {
            button.classList.remove('changes');
            button.classList.add('edit');
            button.textContent = "Edit"

            changeMode(element => {
                const node = document.createElement('div');
                node.className = element.className;
                node.textContent = element.value;
                return node;
            });

            document.querySelectorAll('div.stock').forEach(stock => {
                const text = document.createElement('div');
                text.className = stock.className;
                text.textContent = stock.querySelector('input').value;
                stock.replaceWith(text);
            });
        }
    });

    return container;
}

function buildPendingOrders(orders) {
    const container = document.createElement('div');
    container.className = "container";
    const header = document.createElement('div');
    header.className = "row header";

    ['Order #', 'Purchase Date', 'Pending Status', 'Confirm Status'].forEach(element => {
        const heading = document.createElement('div');
        heading.className = "col-md-3";
        heading.textContent = element;
        header.appendChild(heading);
    });

    container.appendChild(header);

    orders.forEach(order => {
        const row = document.createElement('div');
        row.className = "row table-entry";
        const number = createProductColumn(order.number, 'order');
        const href = document.createElement('a');
        href.className = "col-md-3 col-6 name";
        href.href = '/order/' + order.id;
        href.appendChild(number);
        row.appendChild(href);
        row.appendChild(createProductColumn(order.date, 'date'));
        row.appendChild(createProductColumn(order.status, 'status'));
        const col = createProductColumn('', 'confirm');
        const button = document.createElement('a');
        button.className = "btn btn-primary confirm-order";
        button.textContent = stateStatus[order.status];
        col.appendChild(button);
        row.appendChild(col);
        container.appendChild(row);
    });

    return container;
}

function buildManagers(managers) {
    const container = document.createElement('div');
    container.id = "managers"
    container.className = "container";

    managers.forEach(manager => {
        const row = document.createElement('div');
        row.className = "row table-entry";
        const photo = document.createElement('div');
        const img = document.createElement('img');
        img.src = manager.photo;
        photo.appendChild(img);
        row.appendChild(photo);

        const description = document.createElement('div');
        description.className = "col description";
        const heading = document.createElement('h5');
        const parapgrah = document.createElement('p');
        heading.textContent = manager.name;
        parapgrah.textContent = `Added on ${manager.date}`;
        description.appendChild(heading);
        description.appendChild(parapgrah);
        row.appendChild(description);

        const col = document.createElement('span');
        col.className = "delete-button";
        const button = document.createElement('a');
        button.className = "btn btn-secondary";
        const icon = document.createElement('i');
        icon.className = "fas fa-times";
        button.appendChild(icon);
        col.appendChild(button);
        row.appendChild(col);
        container.appendChild(row);
    });

    const row = document.createElement('div');
    row.className = "row";
    const col = document.createElement('div');
    col.className = "col mt-3 mb-3 center";
    const button = document.createElement('button');
    button.className = "btn rounded-0 btn-lg shadow-none";
    button.id = "add-manager";
    button.type = "button"
    button.setAttribute('data-toggle', 'modal');
    button.setAttribute('data-target', '#addManager');
    button.textContent = "Add New Manager";
    col.appendChild(button);
    row.appendChild(col);

    const modal = document.createElement('div');
    modal.id = "addManager";
    modal.style.display = "none";
    modal.className = "modal fade";
    modal.tabIndex = -1;
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-labelledby', 'addManagerLabel');
    modal.setAttribute('aria-hidden', 'true');
    const dialog = document.createElement('div');
    dialog.className = "modal-dialog";
    dialog.setAttribute('role', 'document');
    modal.appendChild(dialog);
    const content = document.createElement('div');
    content.className = "modal-content";
    dialog.appendChild(content);
    const header = document.createElement('div');
    header.className = "modal-header";
    content.appendChild(header);
    const title = document.createElement('h5');
    title.className = "modal-title";
    title.id = "addManagerLabel";
    title.textContent = "Add New Manager";
    header.appendChild(title);
    const closeButton = document.createElement('button');
    closeButton.className = "close";
    closeButton.setAttribute('type', 'button');
    closeButton.setAttribute('data-dismiss', 'modal');
    closeButton.setAttribute('aria-label', 'Close');
    header.appendChild(closeButton);
    const icon = document.createElement('i');
    icon.className = "fas fa-times";
    closeButton.appendChild(icon);

    const body = document.createElement('div');
    body.className = "modal-body";
    body.appendChild(buildPersonalInfoForm({
        username: "",
        email: "",
        photo: "img/user.png"
    }))
    content.appendChild(body);

    const footer = document.createElement('div');
    footer.className = "modal-footer";
    const saveButton = document.createElement('button');
    saveButton.className = "btn btn-primary";
    saveButton.setAttribute('data-dismiss', 'modal');
    saveButton.textContent = "Confirm";
    footer.appendChild(saveButton);
    content.appendChild(footer);

    row.appendChild(modal);
    container.appendChild(row);



    return container;
}

const managerProfileSections = [{
        name: "Manager Information",
        action: async() => {
            try {
                const data = await fetchData('manager/get');
                return buildPersonalInfo(data);
            } catch (e) {
                return buildErrorMessage(e.status, e.message)
            }
        }
    },
    {
        name: "Stocks",
        action: async() => {
            try {
                const data = await fetchData('manager/stocks');
                return buildStocks(data);
            } catch (e) {
                return buildErrorMessage(e.status, e.message)
            }
        }
    },
    {
        name: "Pending Orders",
        action: async() => {
            try {
                const data = await fetchData('manager/pending-orders');
                return buildPendingOrders(data);
            } catch (e) {
                return buildErrorMessage(e.status, e.message)
            }
        }
    },
    {
        name: "Managers",
        action: async() => {
            try {
                const data = await fetchData('manager/managers');
                return buildManagers(data);
            } catch (e) {
                return buildErrorMessage(e.status, e.message)
            }
        }
    }
];


buildSections(managerProfileSections);