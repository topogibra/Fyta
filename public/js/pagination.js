function createItem(text, isActive) {
    const li = document.createElement('li');
    li.className = "page-item";
    isActive && li.classList.add("active");
    const a = document.createElement('a');
    a.className = "page-link";
    li.appendChild(a);
    a.textContent = text;
    return li;
}

export function buildPagination(activePage, numPages, changePage) {
    if(numPages === 0)
        numPages = 1;
    const ul = document.createElement('ul');
    ul.className = "pagination row justify-content-center";
    const previous = createItem("<");
    ul.appendChild(previous);
    const start = (activePage - 1) <= 0 ? 1 :  activePage === numPages ? activePage - 2 : activePage - 1;
    const end = (activePage + 1) >= numPages ? numPages : start === 1 ? 3 : (activePage + 1);
    for (let i = start; i <= end; i++) {
        const item = createItem(i, activePage === i);
        ul.appendChild(item);
        if (activePage !== i) {
            item.addEventListener('click', () => changePage(i));
        }
    }

    if (activePage > 1)
        previous.addEventListener('click', () => changePage(activePage - 1));


    const next = createItem(">");
    ul.appendChild(next);

    if (activePage < numPages)
        next.addEventListener('click', () => changePage(activePage + 1));

    return ul;
}