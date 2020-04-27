import buildSections from './sections.js';
import buildPersonalInfo from './personal_info.js';
import { fetchData } from './request.js'
import { buildErrorMessage } from './http_error.js';
import buildPendingOrders from './orders.js';
import buildStocks from './stocks.js';
import buildManagers from './managers.js'


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
    action: async () => {
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
    action: async () => {
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
    id: "managers-page",
    action: async () => {
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