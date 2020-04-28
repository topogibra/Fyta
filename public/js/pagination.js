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

export function buildPagination(url, body, activePage, numPages) {
    const ul = document.createElement('ul');
    ul.className = "pagination row justify-content-center";
    ul.appendChild(createItem("Previous"));
    const start = (activePage - 1) <= 0 ? 1 : activePage - 1; 
    const end = (activePage + 1) >= numPages ? numPages : (activePage + 1);   
    for (let i = start; i <= end; i++) {
        ul.appendChild(createItem(i, activePage === i));
    }

    ul.appendChild(createItem("Next"));
    return ul;
}