import { buildModal, buildConfirmation, createProductColumnValue,createProductHeader } from './utils.js';
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

    header.appendChild(createProductHeader('Order #', 2));
    header.appendChild(createProductHeader('Purchase Date', 3));
    header.appendChild(createProductHeader('Pending Status', 3));
    header.appendChild(createProductHeader('Confirm Status', 4));
    container.appendChild(header);

    orders.forEach(order => {
        const row = document.createElement('div');
        row.className = "row table-entry";
        const number = createProductColumnValue(order.number, 'order',2);
        const href = document.createElement('a');
        href.className = "col-md-2 col-6 name";
        href.href = '/order/' + order.id;
        href.appendChild(number);
        row.appendChild(href);
        row.appendChild(createProductColumnValue(order.date, 'date',3));
        const status = createProductColumnValue(order.status, 'status',3);
        row.appendChild(status);
        const col = createProductColumnValue('', 'confirm',4);
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