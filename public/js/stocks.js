import { buildModal, buildConfirmation, createProductColumn } from './utils.js'
import request from './request.js';
import { buildErrorMessage } from './http_error.js';

export default function buildStocks(products) {
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
        row.id = `product-${product.id}`
        row.className = "row table-entry";
        const name = createProductColumn(product.name, 'name');
        const href = document.createElement('a');
        href.href = '/product/' + product.id;
        href.appendChild(name);
        href.className = "col-md-3 col-6 name";
        row.appendChild(href);
        row.appendChild(createProductColumn(product.price, 'price'));
        row.appendChild(createProductColumn(product.stock, 'stock'));
        const col = document.createElement('button');
        col.classList.add(...['col-md-3', 'col-6', 'delete']);
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
    col.className = "col-md-4 col-12 ml-auto mr-0 pr-0";
    const button = document.createElement('a');
    button.className = "btn edit rounded-0 btn-lg shadow-none";
    button.setAttribute('role', 'button');
    button.textContent = 'Edit';
    button.id = "products-button"
    col.appendChild(button);
    row.appendChild(col);
    container.appendChild(row);
    let error;

    col.addEventListener('mousedown',async () => {
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
                    id: n,
                    stock: Number(product.querySelector('input.stock').value)
                }
            });
            console.log(stocks);
            for(let i = 0; i < stocks.length; i++){
                const stock = stocks[i];
                if(!stock.stock){
                    error && error.remove();
                    error = buildErrorMessage('', 'Stock and price must be numbers!');
                    row.appendChild(error);
                    errorFound = true;
                    break;
                }
            }

            if(!errorFound){
                error && error.remove();
                try{
                    const response  = await request({
                        url: '/manager/stocks',
                        method: 'PUT',
                        content: stocks
                    });
    
                    if(response.status != 200) {
                        error && error.remove();
                        error = buildErrorMessage(response.status, 'An error has ocurred please try again later!');
                        row.appendChild(error);
                    }
    
                }catch(e){
                    error && error.remove();
                    error = buildErrorMessage(e.status, 'An error has ocurred please try again later!');
                    row.appendChild(error);
                    row.appendChild(buildErrorMessage(e.status, 'An error has ocurred please try again later!'));
                }
                button.classList.remove('changes');
                button.classList.add('edit');
                button.textContent = "Edit"

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
