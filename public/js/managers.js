import { buildPersonalInfoForm } from './personal_info.js';
import request from './request.js';
import { validateRequirements, buildErrorMessage } from './http_error.js';
import { buildModal, buildConfirmation } from './utils.js';

export default function buildManagers(managers) {
    const container = document.createElement('div');
    container.id = "managers"
    container.className = "container";
    managers.forEach(manager => {
        const row = document.createElement('div');
        row.className = "row table-entry";
        const photo = document.createElement('div');
        const img = document.createElement('img');
        img.src = manager.photo;
        img.alt = `${manager.name}'s Photo`
        photo.appendChild(img);
        row.appendChild(photo);

        const description = document.createElement('div');
        description.className = "col description";
        const heading = document.createElement('h5');
        const parapgrah = document.createElement('p');
        heading.textContent = manager.name;
        parapgrah.textContent = `Added on ${manager.date}`;
        description.appendChild(heading);
        description.appendChild(parapgrah);
        row.appendChild(description);

        const col = document.createElement('span');
        col.className = "delete-button";
        const button = document.createElement('a');
        button.className = "btn btn-secondary";
        button.setAttribute('data-toggle', 'modal');
        const deleteId = `manager-${manager.id}`;
        button.setAttribute('data-target', `#${deleteId}`);

        const modal = buildModal('Are you sure you want to delete?', buildConfirmation(async () => {
            const result = await request({
                url: `/manager/${manager.id}`,
                method: 'DELETE',
                content: {}
            });
            if (result.status != 200)
                throw { status: result.status, message: 'Failed to delete, please try again later.' }
            else
                document.getElementById('managers-page').dispatchEvent(new Event('mousedown'));
            return result;
        }), deleteId, deleteId+"Label");

        container.appendChild(modal);
        const icon = document.createElement('i');
        icon.className = "fas fa-times";
        button.appendChild(icon);
        col.appendChild(button);
        row.appendChild(col);
        container.appendChild(row);
    });

    if (managers.length == 0) {
        const noManagersContainer = document.createElement('p');
        noManagersContainer.className = "text-center";
        noManagersContainer.textContent = "No other managers were found.";
        container.appendChild(noManagersContainer);
    }

    const row = document.createElement('div');
    row.className = "row";
    const col = document.createElement('div');
    col.className = "col mt-3 mb-3 center";
    const button = document.createElement('button');
    button.className = "btn rounded-0 btn-lg shadow-none";
    button.id = "add-manager";
    button.type = "button"
    const managerId = 'addManager';
    button.setAttribute('data-toggle', 'modal');
    button.setAttribute('data-target', `#${managerId}`);
    button.textContent = "Add New Manager";
    col.appendChild(button);
    row.appendChild(col);
    let errors;

    const modal = buildModal("Add New Manager", buildPersonalInfoForm({
        username: "",
        email: "",
        photo: "img/user.png"
    }), managerId, managerId+"Label");


    const form = modal.querySelector('form');
    const footer = document.createElement('div');
    footer.className = "modal-footer";
    const saveButton = document.createElement('button');
    saveButton.className = "btn btn-primary";
    saveButton.textContent = "Confirm";
    footer.appendChild(saveButton);
    form.appendChild(footer);
    const picInput = form.querySelector('#img');

    const createManager = async (event) => {
        event.preventDefault();
        const validation = ['username', 'email', 'password', 'img']
        const validationErrors = validateRequirements(validation);
        if (validationErrors) {
            errors && errors.remove();
            errors = validationErrors;
            footer.prepend(errors);
        } else {
            errors && errors.remove();
            const content = {};
            validation.forEach((id) => {
                content[id] = document.getElementById(id).value;
            });

            content.photo = picInput.files[0];
            try {
                const response = await request({
                    url: '/manager/create',
                    method: 'POST',
                    content
                }, true);
                if (response.status != 200) {
                    footer.prepend(buildErrorMessage("", response.content));
                } else {
                    $(`#${managerId}`).modal('hide');
                    document.getElementById('managers-page').dispatchEvent(new Event('mousedown'));
                }
            } catch (e) {
                if (e.status == 400) {
                    const { status, ...errors } = e;
                    e.message = Object.keys(errors).map(key => errors[key] + " ").join();
                }
                footer.prepend(buildErrorMessage(e.status, e.message));
            }
        }
    };
    form.addEventListener('submit', createManager);
    modal.querySelector('button.btn.btn-primary').addEventListener('submit', createManager);

    row.appendChild(modal);
    container.appendChild(row);



    return container;
}