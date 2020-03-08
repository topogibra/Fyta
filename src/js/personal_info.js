export function buildPersonalInfoForm(info, user){
    const container = document.createElement('div');
    container.className = "container";

    const form = document.createElement('form');
    form.className = ".form-inline";
    container.appendChild(form);

    const imgRow = document.createElement('div');
    imgRow.className = "row justify-content-center";
    form.appendChild(imgRow);
    const img = document.createElement('img');
    img.className = "mx-auto d-block img-fluid rounded-circle border border-dark rounded";
    img.alt = "User Image";
    img.id = "user-img";
    img.src = info.photo;
    imgRow.appendChild(img);

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

        const label = document.createElement('label');
        label.setAttribute('for', id);
        col.appendChild(label);
        
    }

    buildInput('text', 'username', 'Username', info.username, personalInfoCol);
    buildInput('text', 'email', 'Email', info.email, personalInfoCol);

    if(user) {
        buildInput('text', 'address', 'Address', info.address, personalInfoCol);
    
        const birthdayHeader = document.createElement('div');
        birthdayHeader.className = "row justify-content-center";
        form.appendChild(birthdayHeader);
        const birthdayCol = document.createElement('div');
        birthdayCol.className = "col-12";
        birthdayHeader.appendChild(birthdayCol);
        const heading = document.createElement('h4');
        heading.id = "birthday";
        heading.textContent = "Birthday";
        birthdayHeader.appendChild(heading);
    
    
        const birthdayInputs = document.createElement('div');
        birthdayInputs.className = "row form-group justify-content-center birthday";
        form.appendChild(birthdayInputs);
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
    
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        const years = ['2000', '1999', '1998', '1997', '1996', '1995', '1996'];
    
        buildSelectionColumn("day", Array.from({length: 31}).map((_, i) => String(i + 1)), info.day);
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


export default function buildPersonalInfo(info, user) {
    const container = buildPersonalInfoForm(info, user);

    const form = container.querySelector('form');
    const saveChanges = document.createElement('div');
    saveChanges.className = "row justify-content-end";
    saveChanges.id = "save-changes";
    const saveChangesCol = document.createElement('div');
    saveChangesCol.className = "col-md-4";
    saveChanges.appendChild(saveChangesCol);
    const saveChangesButton = document.createElement('button');
    saveChangesButton.type = "button";
    saveChangesButton.className = "btn btn-primary col-sm-12";
    saveChangesButton.id = "submitbutton";
    saveChangesButton.textContent = "Save Changes";
    saveChangesCol.appendChild(saveChangesButton);
    form.appendChild(saveChanges);

    return container;
}