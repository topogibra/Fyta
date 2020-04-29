import buildSections from './sections.js';
import { buildPage } from './sections.js'
import buildPersonalInfo from './personal_info.js';
import { fetchData } from './request.js'
import { buildErrorMessage } from './http_error.js';
import { buildPagination } from './pagination.js'
import buildPendingOrders from './orders.js';
import buildStocks from './stocks.js';
import buildManagers from './managers.js'

async function pendingOrders(page = 1) {
    try {
        const response = await fetchData('manager/pending-orders', page);
        const container = buildPendingOrders(response.orders);
        container.appendChild(buildPagination(page, response.pages, (page) => {
            buildPage({
                name: "Pending Orders",
                action: async () => await pendingOrders(page)
            });
        }));
        return container;
    } catch (e) {
        return buildErrorMessage(e.status, e.message)
    }
}


async function managers(page = 1) {
    try {
        const response = await fetchData('manager/managers', page);
        const container = buildManagers(response.managers);
        container.appendChild(buildPagination(page, response.pages, (page) => {
            buildPage({
                name: "Pending Orders",
                action: async () => await managers(page)
            });
        }));

        return container;
    } catch (e) {
        return buildErrorMessage(e.status, e.message)
    }
}

async function stocks(page = 1) {
    try {
        const response = await fetchData('manager/stocks');
        const container = buildStocks(response.stocks);
        container.appendChild(buildPagination(page, response.pages, (page) => {
            buildPage({
                name: "Pending Orders",
                action: async () => await stocks(page)
            });
        }));

        return container;
    } catch (e) {
        return buildErrorMessage(e.status, e.message)
    }
}


const managerProfileSections = [{
    name: "Manager Information",
    action: async () => {
        try {
            const data = await fetchData('manager/user');
            return buildPersonalInfo(data);
        } catch (e) {
            return buildErrorMessage(e.status, e.message)
        }
    }
},
{
    name: "Stocks",
    action: stocks
},
{
    name: "Pending Orders",
    action: pendingOrders
},
{
    name: "Managers",
    id: "managers-page",
    action: managers
}
];


buildSections(managerProfileSections);