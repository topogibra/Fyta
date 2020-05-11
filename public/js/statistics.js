import { buildCalendar } from './calendar.js';
import { buildModal } from './utils.js';
import request from './request.js';

let startDate;
let endDate;
const canvas = document.createElement('canvas');

function generateDateRow(type) {

    const date = document.createElement('div');
    date.className = "col";
    const id = `${type}-date`;

    const startInput = document.createElement('div');
    const header = document.createElement('h5');
    header.textContent = type
    
    const input = document.createElement('div');
    startInput.className = "date-input btn btn-outline-success"
    startInput.setAttribute('data-target', `#${id}`);
    startInput.setAttribute('data-toggle', 'modal');
    startInput.appendChild(header);
    date.appendChild(startInput);
    startInput.appendChild(input);

    const calendar = buildCalendar(new Date(), true, async (date) => {
        if (type === "Begin")
            startDate = date;
        else
            endDate = date;
        
        input.textContent = date;


        $(`#${id}`).modal('hide');
        if (startDate && endDate && startDate < endDate) {
            const mostSold = await request({
                url: '/statistics/most-sold',
                content: {
                    start: startDate,
                    end: endDate,
                    limit: 10
                },
                method: 'POST'
            });

            const colors = ['rgb(135, 156, 232)', 'rgb(185, 151, 198)',
                'rgb(130, 77, 153)', 'rgb(78, 121, 196)', 'rgb(87, 162, 172)',
                'rgb(126, 184, 117)', 'rgb(208, 180, 64)', 'rgb(230, 127, 51)',
                'rgb(206, 34, 32)', 'rgb(82, 25, 19)'].reverse();

            const pieChart = new Chart(canvas, {
                type: 'bar',
                showTooltips: false,
                data: {
                    datasets: [{
                        label: `Most Sold Items between ${startDate} and ${endDate}`,
                        data: mostSold.map(product => product.sold),
                        backgroundColor: colors,
                    }],

                    labels: mostSold.map(product => product.name)
                },
                options: { scales: { yAxes: [{ ticks: { beginAtZero: true } }] } }
            });
        }
    });
    date.appendChild(buildModal("Insert the beggining date of your query", calendar, id));
    return date;
}

export default function buildStatistics() {
    const container = document.createElement('article');
    const row = document.createElement('div');
    row.className = "row justify-content-between";
    container.appendChild(row);
    row.appendChild(generateDateRow("Begin"));
    row.appendChild(generateDateRow("End"));

    container.appendChild(canvas);
    return container;
}