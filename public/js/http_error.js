export function buildErrorMessage(error, message) {
    const container = document.createElement('div');
    container.className = 'container d-flex h-100 align-items-center justify-content-center';
    const msgBox = document.createElement('div');
    msgBox.className = "alert";
    msgBox.id = "errors";
    msgBox.textContent = 'Error ' + error + ': ' + message;
    container.appendChild(msgBox);

    return container
}

export function validateRequirements(requiredInputs) {

    const errorsArray = [];

    requiredInputs.forEach((id) => {
        const input = document.getElementById(id);
        if (!input.value){
            errorsArray.push(id);
        }
    });

    if(errorsArray.length > 0){
        const errors = document.createElement('ul');
        errors.id = "errors";
        errors.className = "alert";
        errorsArray.forEach((id) => {
            const li = document.createElement('li');
            li.textContent = `${id} is required`;
            errors.appendChild(li);
        });
        return errors;
    }
    return false;
}