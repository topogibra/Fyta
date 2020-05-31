import { buildModal, buildConfirmation, createProductColumnValue, createProductHeader } from './utils.js'
import request from './request.js';
import { buildErrorMessage } from './http_error.js';

export default function buildStocks(products) {
    const container = document.createElement('div');
    container.className = "container";
    const header = document.createElement('div');
    header.className = "row header";


    header.appendChild(createProductHeader('Product', 6));
    header.appendChild(createProductHeader('Price', 2));
    header.appendChild(createProductHeader('Stock', 2));
    header.appendChild(createProductHeader('Delete', 2));


    container.appendChild(header);

    products.forEach(product => {
        const row = document.createElement('div');
        row.id = `product-${product.id}`
        row.className = "row table-entry";
        const name = createProductColumnValue(product.name, 'name', 12);
        const href = document.createElement('a');
        href.href = '/product/' + product.id;
        href.appendChild(name);
        href.className = "col-md-6 name";
        row.appendChild(href);
        row.appendChild(createProductColumnValue(product.price + "€", 'price', 2));
        row.appendChild(createProductColumnValue(product.stock + "uni", 'stock', 2));
        const col = document.createElement('button');
        col.classList.add(...['col-md-2', 'delete']);
        col.type = "button";
        col.setAttribute('data-toggle', 'modal');
        const deleteId = `delete-${product.id}`
        col.setAttribute('data-target', `#${deleteId}`);
        const icon = document.createElement('i');
        icon.className = "fas fa-trash";
        const modal = buildModal('Are you sure you want to delete?', buildConfirmation(async () => {
            const result = await request({
                url: `/product/${product.id}`,
                method: 'DELETE',
                content: {}
            });
            if (result.status != 200)
                throw { status: result.status, message: 'Failed to delete, please try again later.' }
            row.remove();
            return result;
        }), deleteId)
        container.appendChild(modal);
        col.appendChild(icon);
        row.appendChild(col);
        container.appendChild(row);
    });

    const row = document.createElement('div');
    row.className = "row";
    const col = document.createElement('div');
    col.className = "col-md-4 ml-auto mr-0 pr-0";
    const button = document.createElement('a');
    button.className = "btn edit rounded-0 btn-lg shadow-none";
    button.setAttribute('role', 'button');
    button.textContent = 'Edit';
    button.id = "products-button"
    col.appendChild(button);
    row.appendChild(col);
    container.appendChild(row);
    let error;

    const changeMode = (nodeCreation) => {
        ['name', 'price'].forEach(elementClass => {
            const elements = document.querySelectorAll(`.${elementClass}`);
            elements.forEach(element => element.replaceWith(nodeCreation(element)));
        });
    }
    col.addEventListener('mousedown', async () => {
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
                minus.addEventListener('mousedown', () => input.value = Number(input.value) - 1);
                plus.addEventListener('mousedown', () => input.value = Number(input.value) + 1);
                const wrapper = document.createElement('div');
                wrapper.className = stock.className;
                wrapper.classList.add('stock-wrapper')
                wrapper.appendChild(minus);
                wrapper.appendChild(input);
                wrapper.appendChild(plus);
                stock.replaceWith(wrapper);
            });

        } else {
            let errorFound;
            const stocks = products.map(product => product.id).map(n => {
                const product = document.querySelector(`#product-${n}`);
                return {
                    id: n + 1,
                    name: product.querySelector('input.name').value,
                    price: Number(product.querySelector('input.price').value),
                    stock: Number(product.querySelector('input.stock').value)
                }
            });
            for (let i = 0; i < stocks.length; i++) {
                const stock = stocks[i];
                if (!stock.price || !stock.stock) {
                    error && error.remove();
                    error = buildErrorMessage('', 'Stock and price must be numbers!');
                    row.appendChild(error);
                    errorFound = true;
                    break;
                }
            }

            if (!errorFound) {
                error && error.remove();
                try {
                    const response = await request({
                        url: '/manager/stocks',
                        method: 'PUT',
                        content: stocks
                    });

                    if (response.status != 200) {
                        error && error.remove();
                        error = buildErrorMessage(response.status, 'An error has ocurred please try again later!');
                        row.appendChild(error);
                    }

                } catch (e) {
                    error && error.remove();
                    error = buildErrorMessage(e.status, 'An error has ocurred please try again later!');
                    row.appendChild(error);
                    row.appendChild(buildErrorMessage(e.status, 'An error has ocurred please try again later!'));
                }
                button.classList.remove('changes');
                button.classList.add('edit');
                button.textContent = "Edit"

                document.querySelectorAll('.price').forEach(currentNode => {
                    const node = document.createElement('div');
                    node.className = currentNode.className;
                    node.textContent = currentNode.value;
                    currentNode.replaceWith(node);
                });

                document.querySelectorAll('.name').forEach((currentNode, index) => {
                    const href = document.createElement('a');
                    href.href = '/product/' + products[index].id;
                    const node = document.createElement('div');
                    href.appendChild(node);
                    href.className = currentNode.className;
                    node.textContent = currentNode.value;
                    currentNode.replaceWith(href);
                });

                document.querySelectorAll('div.stock').forEach(stock => {
                    const text = document.createElement('div');
                    text.className = stock.className;
                    text.textContent = stock.querySelector('input').value;
                    stock.replaceWith(text);
                });
            }
        }
    });

    return container;
}
