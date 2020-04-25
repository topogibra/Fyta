import { buildModal, buildConfirmation, createProductColumn } from './utils.js';
import request from './request.js';

const stateStatus = {
    'Ready for Shipping': 'Confirm Shipping',
    'Awaiting Payment': 'Awaiting Payment'
}

export default function buildPendingOrders(orders) {
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
        const status = createProductColumn(order.status, 'status');
        row.appendChild(status);
        const col = createProductColumn('', 'confirm');
        const button = document.createElement('a');
        button.setAttribute('role', 'button');
        button.className = "btn btn-primary confirm-order";
        button.textContent = stateStatus[order.status];
        col.setAttribute('data-toggle', 'modal');
        const deleteId = `delete-${order.id}`
        col.setAttribute('data-target', `#${deleteId}`);
        const icon = document.createElement('i');
        icon.className = "fas fa-trash";
        const modal = buildModal('Are you sure you want to update the order\'s status?', buildConfirmation(async () => {
            const order_status = order.status === "Awaiting Payment" ? 'Ready_for_Shipping' : 'Processed';
            const result = await request({
                url: '/order/update',
                method: 'POST',
                content: {
                    order_id: order.id,
                    order_status
                }
            });
            if (result.status != 200)
                throw { status: result.status, message: 'Failed to update, please try again later.' }

            if (order_status === "Processed")
                row.remove();
            else {
                status.textContent = order_status.split('_').join(' ');
                order.status = status.textContent;
                button.textContent = stateStatus[status.textContent];
            }
            return result;
        }), deleteId)
        container.appendChild(modal);
        col.appendChild(button);
        row.appendChild(col);
        container.appendChild(row);
    });

    return container;
}