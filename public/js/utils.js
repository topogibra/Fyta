export function removeAll(node){
    while (node.firstElementChild){
        node.removeChild(node.firstElementChild)
    }
}

export function buildModal(pageName, modalContent, modalId) {
    const modal = document.createElement('div');
    modal.id = modalId;
    modal.style.display = "none";
    modal.className = "modal fade";
    modal.tabIndex = -1;
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-labelledby', 'addManagerLabel');
    modal.setAttribute('aria-hidden', 'true');
    const dialog = document.createElement('div');
    dialog.className = "modal-dialog";
    dialog.setAttribute('role', 'document');
    modal.appendChild(dialog);
    const content = document.createElement('div');
    content.className = "modal-content";
    dialog.appendChild(content);
    const header = document.createElement('div');
    header.className = "modal-header";
    content.appendChild(header);
    const title = document.createElement('h5');
    title.className = "modal-title";
    title.id = "addManagerLabel";
    title.textContent = pageName;
    header.appendChild(title);
    const closeButton = document.createElement('button');
    closeButton.className = "close";
    closeButton.setAttribute('type', 'button');
    closeButton.setAttribute('data-dismiss', 'modal');
    closeButton.setAttribute('aria-label', 'Close');
    header.appendChild(closeButton);
    const icon = document.createElement('i');
    icon.className = "fas fa-times";
    closeButton.appendChild(icon);

    const body = document.createElement('div');
    body.className = "modal-body";
    body.appendChild(modalContent);
    content.appendChild(body);
    return modal;
}

export function buildConfirmation(action) {
    const container = document.createElement('div');
    container.className = "row justify-content-around";
    const accept = document.createElement('a');
    accept.href = '#'
    accept.className = "col-4 btn-primary"
    accept.textContent = "Yes"
    const reject = document.createElement('a');
    reject.href = '#'
    reject.className = "col-4 btn-danger"
    reject.textContent = "No"
    container.appendChild(accept);
    container.appendChild(reject);
    reject.setAttribute('role', 'button');
    reject.setAttribute('data-dismiss', 'modal');
    reject.setAttribute('aria-label', 'Close');
    accept.addEventListener('mousedown', async () => {
        await action();
        reject.click();
        try {
        } catch (error) {
            container.appendChild(buildErrorMessage(error.status, error.message));
        }
    });
    return container;
}

export function buildAccept(action) {
    const container = document.createElement('div');
    container.className = "row justify-content-center";
    container.id = "confbutton"
    const accept = document.createElement('a');
    accept.href = '#'
    accept.className = "col-8 btn-primary"
    accept.textContent = "Confirm delete"
    container.appendChild(accept);
    accept.addEventListener('mousedown', async () => {
        await action();
        try {
        } catch (error) {
            container.appendChild(buildErrorMessage(error.status, error.message));
        }
    });
    return container;
}

export function createProductHeader(element, mdvalue) {
    const heading = document.createElement('div');
    heading.className = 'col-md-'+mdvalue;
    heading.textContent = element;
    return heading;
}

export function createProductColumn(info, attribute, value) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-' + value, 'col-6', attribute]);
    column.textContent = info;
    return column;
}

export function createProductColumnValue(info, attribute, value) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-' + value,'col-6','text-center',attribute]);
    column.textContent = info;
    return column;
}


export function createSalesColumnValue(info, attribute, value, value_default) {
    const column = document.createElement('div');
    column.classList.add(...['col-md-' + value,'col-' + value_default,'text-center',attribute]);
    column.textContent = info;
    return column;
}