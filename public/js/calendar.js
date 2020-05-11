const urlParams = new URL(window.location).searchParams;

let selecting = false;
let currentStart, currentEnd;
let currentYear, currentMonth;

const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

const weekDays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

function generateYearandMonthString(date) {
    const month = date.getMonth() + 1;
    return `${date.getFullYear()}-${month < 10 ? '0' + month : month}`;
}

function generateDateString(date, text) {
    return `${generateYearandMonthString(date)}-${text < 10 ? '0' + text : text}`;
}

export function updatePrice(checkin, checkout) {
    const housePrice = document.querySelector('#reserve div:nth-child(4) p:last-child strong');
    const totalPrice = document.querySelector('#reserve div:nth-child(4) p:first-child strong');
    const numDays = (checkout - checkin) / (1000 * 60 * 60 * 24) + 1;
    totalPrice.innerText = Number(housePrice.innerText) * numDays;
}

export function buildCalendar(date, single, callback) {
    const article = document.createElement('article');
    article.setAttribute('class', 'calendar');
    const title = document.createElement('div');
    const titleText = document.createElement('h5');
    title.appendChild(titleText);
    if (single) {
        const previous = document.createElement('i');
        previous.setAttribute('class', 'fa fa-chevron-left');
        previous.addEventListener('click', () =>
            article.replaceWith(buildCalendar(new Date(date.getFullYear(), date.getMonth() - 1), true, callback))
        );
        const next = document.createElement('i');
        next.setAttribute('class', 'fa fa-chevron-right');
        next.addEventListener('click', () =>
            article.replaceWith(buildCalendar(new Date(date.getFullYear(), date.getMonth() + 1), true, callback))
        );
        title.insertBefore(previous, titleText);
        title.insertBefore(next, title.nextSibling);
        title.setAttribute('class', 'controllers');
    }

    article.appendChild(title);
    const table = document.createElement('table');
    article.appendChild(table);
    const tableHead = document.createElement('thead');
    const headRow = document.createElement('tr');
    table.appendChild(tableHead);
    tableHead.appendChild(headRow);
    weekDays.forEach(day => {
        const cell = document.createElement('th');
        cell.innerText = day;
        headRow.appendChild(cell);
    });

    const tableCells = [];
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            tableCells.push(cell);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }

    const month = date.getMonth();
    const year = date.getFullYear();
    titleText.innerText = `${months[month]} ${year}`;
    const numDays = new Date(year, month + 1, 0).getDate();
    let day = new Date(year, month).getDay();
    currentMonth = month;
    currentYear = year;
    const now = new Date();
    for (let i = 1; i <= numDays; i++, day++) {
        if (now < new Date(year, month, i)) {
            tableCells[day].setAttribute('class', 'past-date unavailable');
        }
        tableCells[day].innerText = i;
    }

    if (single) {
        calendarClicks(article, date, callback);
    }
    return article;
}

function fillSelected(start, end, table) {
    for (let j = 0; j < table.length; j++) {
        if (j >= start && j <= end) table[j].setAttribute('class', 'selected');
        else if (table[j].className.search('unavailable') == -1) table[j].removeAttribute('class');
    }
}

function fillSelectedDate(startDate, endDate, table) {
    for (let j = 0; j < table.length; j++) {
        if (
            table[j].innerText != '' &&
            new Date(currentYear, currentMonth, Number(table[j].innerText) + 1) >= startDate &&
            new Date(currentYear, currentMonth, table[j].innerText) <= endDate
        )
            table[j].setAttribute('class', 'selected');
        else if (table[j].className.search('unavailable') == -1) table[j].removeAttribute('class');
    }
}

function removeSelected(cells) {
    cells.forEach(day => {
        if (day.className.search('unavailable') == -1) day.removeAttribute('class');
    });
}

function calendarClicks(article, date, callback) {
    const table = article.querySelector('table');
    const cells = table.querySelectorAll('td');
    cells.forEach(day => {
        day.className.search('unavailable') == -1 &&
            day.innerText != '' &&
            day.addEventListener('click', () =>
                callback(generateDateString(date, day.innerText)));
    });

    if (currentStart && currentEnd) {
        fillSelectedDate(currentStart, currentEnd, cells);
    }
}

export async function validateDate(startDate, endDate, cells) {
    const unavailable = [].find.call(
        cells,
        cell =>
            cell.className.search('unavailable') != -1 &&
            startDate.getDate() <= cell.innerText &&
            endDate.getDate() >= cell.innerText
    );
    if (unavailable) return false;
    fillSelectedDate(startDate, endDate, cells);
    currentStart = startDate;
    currentEnd = endDate;
    return true;
}