import { validateRequirements } from './http_error.js';
import request from './request.js'
import { deleteAccount } from './request.js'
import { buildModal, buildAccept } from './utils.js';

export function buildPersonalInfoForm(info, user) {
    const container = document.createElement('div');
    container.className = "container";

    const form = document.createElement('form');
    form.className = ".form-inline";
    container.appendChild(form);

    const imgRow = document.createElement('div');
    imgRow.className = "row justify-content-center";
    const label = document.createElement('label');
    label.setAttribute('for', 'img');
    form.appendChild(imgRow);
    const img = document.createElement('img');
    img.className = "mx-auto d-block img-fluid rounded-circle border border-dark rounded";
    img.alt = "User Image";
    img.id = "user-img";
    img.src = info.photo;
    label.appendChild(img);
    imgRow.appendChild(label);
    const photo = document.createElement('input')
    photo.type = 'file';
    photo.id = "img";
    photo.name = "img";
    imgRow.appendChild(photo);
    photo.addEventListener('change', () => {
        if (photo.files && photo.files[0]) {
            const reader = new FileReader();
            reader.onload = e => (img.src = e.target.result);

            reader.readAsDataURL(photo.files[0]);
        }
    });


    const personalInfo = document.createElement('div');
    personalInfo.className = "row form-group justify-content-center";
    form.appendChild(personalInfo);
    const personalInfoCol = document.createElement('div');
    personalInfoCol.className = "col-12";
    personalInfo.appendChild(personalInfoCol);
    const buildInput = (type, id, placeholder, value, col) => {
        const input = document.createElement('input');
        input.type = type;
        input.className = "form-control registerinput";
        input.id = id;
        input.name = id;
        input.placeholder = placeholder;
        input.value = value;
        col.appendChild(input);
    }

    buildInput('text', 'username', 'Username', info.username, personalInfoCol);
    buildInput('text', 'email', 'Email', info.email, personalInfoCol);

    if (user) {
        buildInput('text', 'address', 'Address', info.address, personalInfoCol);
        buildInput('text', 'security-question', 'Security Question', info.security_question, personalInfoCol);


        const fieldSet = document.createElement('fieldset');
        const birthdayHeader = document.createElement('legend');
        birthdayHeader.className = "row bd";
        fieldSet.appendChild(birthdayHeader);
        const birthdayCol = document.createElement('div');
        birthdayCol.className = "col-12";
        birthdayHeader.appendChild(birthdayCol);
        const heading = document.createElement('h4');
        heading.id = "birthday";
        heading.textContent = "Birthday";
        birthdayHeader.appendChild(heading);
        form.appendChild(fieldSet);

        const birthdayInputs = document.createElement('div');
        birthdayInputs.className = "row form-group justify-content-center birthday";
        fieldSet.appendChild(birthdayInputs);
        const buildSelectionColumn = (id, options, placeholder) => {
            const optionsCol = document.createElement('div');
            optionsCol.className = "col";
            const select = document.createElement('select');
            optionsCol.appendChild(select);
            select.className = "custom-select custom-select-sm registerinput registerSelect";
            select.id = id;
            select.name = id;
            const placeholderOption = document.createElement('option');
            placeholderOption.className = "text-muted optionplaceholder";
            placeholderOption.text = placeholder;
            select.appendChild(placeholderOption);
            options.forEach(optionValue => {
                const option = document.createElement('option');
                option.value = optionValue;
                option.textContent = optionValue;
                select.appendChild(option);
            });
            birthdayInputs.appendChild(optionsCol);
        };

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let years = [];
        const currYear = new Date().getFullYear();
        for (let i = 0; i < 100; i++) {
            years.push((currYear - i).toString());
        }

        buildSelectionColumn("day", Array.from({ length: 31 }).map((_, i) => String(i + 1)), info.day);
        buildSelectionColumn("month", months, info.month);
        buildSelectionColumn("year", years, info.year);
    }


    const passwordInput = document.createElement('div');
    passwordInput.className = "row justify-content-end";
    form.appendChild(passwordInput);

    const passwordCol = document.createElement('div');
    passwordCol.className = "col-12";
    passwordInput.appendChild(passwordCol);
    buildInput('password', 'password', 'Password', "", passwordCol);


    return container;
}

let errors;

export default function buildPersonalInfo(info, user) {
    const container = buildPersonalInfoForm(info, user);

    const form = container.querySelector('form');
    const saveChanges = document.createElement('div');
    saveChanges.className = "row justify-content-end";
    saveChanges.id = "save-changes";
    const saveChangesCol = document.createElement('div');
    saveChangesCol.className = "col-md-6 col-12 justify-content-end";
    saveChanges.appendChild(saveChangesCol);
    const saveChangesButton = document.createElement('button');
    saveChangesButton.role = "button";
    saveChangesButton.className = "btn rounded-0 btn-lg shadow-none";
    saveChangesButton.id = "savechanges";
    saveChangesButton.textContent = "Save Changes";
    saveChangesCol.appendChild(saveChangesButton);
    form.appendChild(saveChanges);
    const modalId = "success";
    const picInput = container.querySelector('#img');

    form.addEventListener('submit', async (ev) => {
        ev.preventDefault();
        const validation = ['username', 'email'];
        if (user) {
            validation.push(...['address', 'day', 'month', 'year']);
        }

        const validationErrors = validateRequirements(validation);
        if (validationErrors) {
            errors && errors.remove();
            saveChanges.className = "row justify-content-between"
            saveChanges.prepend(validationErrors);
            errors = validationErrors;
        } else {
            errors && errors.remove();
            saveChanges.className = "row justify-content-end";
            const content = {};
            validation.forEach((id) => {
                content[id] = document.getElementById(id).value;
            });
            if (user) {
                const day = document.getElementById('day').value;
                const month = document.getElementById('month').value;
                const year = document.getElementById('year').value;
                const birthday = year + '-' + month + '-' + day;
                content['birthday'] = birthday;
            }

            const password = document.getElementById('password');
            if (password.value)
                content['password'] = password.value;

            if (picInput.files.length > 0) {
                console.log(picInput.files[0]);
                content.photo = picInput.files[0];
            }

            try {
                const response = await request({
                    url: user ? '/profile/update' : '/manager',
                    method: 'POST',
                    content
                }, true);
                if (response.status != 200) {
                    saveChanges.prepend(buildErrorMessage(response.status, response.content));
                } else {
                    $(`#${modalId}`).toast({ delay: 3000 });
                    $(`#${modalId}`).toast('show');
                }
            } catch (e) {
                saveChanges.prepend(buildErrorMessage(e.status, e.message));
            }
        }
        return false;
    });

    const remove = document.createElement('div');
    remove.className = "row justify-content-end";
    remove.id = "remove-account";
    const remove_a = document.createElement('a');
    remove_a.text = "Remove Account";
    remove_a.id = "remove-a";
    remove_a.href = "customer/" + info.username;
    remove_a.setAttribute('data-toggle', 'modal');
    remove_a.setAttribute('data-target', '#removemodal');
    remove_a.className = "btn rounded-0 btn-lg shadow-none";
    remove.appendChild(remove_a);
    container.appendChild(remove);

    remove_a.addEventListener('click', async (ev) => {
        ev.preventDefault();
    });

    const modalremove = buildModal('Can you please explain why you want to remove your account?', buildAccept(async () => {

        let reason = document.querySelector('#reason').value;
        if (reason == "")
            reason = 'didntanswer';

        let response = await deleteAccount(remove_a.href, reason);

        if (response.status != 200) {
            return false;
        }
        else
            window.location.replace("/home");

    }), 'removemodal');
    const modalbody = modalremove.lastChild.lastChild.children[1];
    const text = document.createElement('p');
    text.className = "text-center"
    text.textContent = "Are you sure you want to delete your account?"
    modalbody.prepend(text)
    const inputreason = document.createElement('input');
    inputreason.id = "reason";
    inputreason.type = "text";
    inputreason.className = "form-control";
    modalbody.prepend(inputreason)


    container.appendChild(modalremove);

    const modal = document.createElement('div');
    modal.className = "toast";
    modal.id = modalId;
    modal.setAttribute('role', 'alert');
    modal.setAttribute('aria-live', 'assertive');
    modal.setAttribute('aria-atomic', 'true');
    const modalBody = document.createElement('div');
    modalBody.textContent = "Saved changes"
    modal.appendChild(modalBody);
    container.appendChild(modal);

    return container;
}