import buildSections from './sections.js'

function createProductColumn(info, attribute) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-2', 'col-6', attribute]);
    column.textContent = info;
    return column;
}

function buildStocks(products){
    const container = document.createElement('div');
    container.className = "container";
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
    col.className = "col-2 ml-auto pr-0";
    const button = document.createElement('a');
    button.className = "btn btn-primary w-100 mt-3 edit";
    button.setAttribute('role', 'button');
    button.textContent = 'Edit';
    button.id = "products-button"
    col.appendChild(button);
    row.appendChild(col);

    const changeMode = (nodeCreation) => {
        ['name', 'price'].forEach(elementClass => {
            const elements = document.querySelectorAll(`.${elementClass}`);
            elements.forEach(element => element.replaceWith(nodeCreation(element)));
        });
    } 
    col.addEventListener('mousedown', () => {
        if(button.classList.contains('edit')){
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
                minus.addEventListener('mousedown', () => stock.value = Number(stock.value) - 1 );
                plus.addEventListener('mousedown', () => stock.value = Number(stock.value) + 1 );
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

    return [container, row];
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