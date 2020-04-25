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

        if (id == 'template-img') {
            if (input.src == null || input.src == window.location.origin + "/img/template_img.png") {
                errorsArray.push({
                    'id': id,
                    'message': " is required"
                });
            }
        } else if (!input.value) {
            errorsArray.push({
                'id': id,
                'message': " is required"
            });
        }

        switch (id) {
            case "username", "email", "address", "name", "deliveryaddress", "billingaddress", "description":
                if (!(validateMaxSize(input.value) || errorsArray.find(() => ({ 'id': id })))) {
                    errorsArray.push({
                        'id': id,
                        'message': " to big. Max of 255 caracters"
                    });
                }
                break;
            case "password": //TODO: already created accounts wont be validated without this parameter
                if (!(validateMinSize(input.value) || errorsArray.find(() => ({ 'id': id }))))
                    errorsArray.push({
                        'id': id,
                        'message': " is incorrect. At least 6 digits are needed"
                    });
                break;
            case "birthday":
                const day = document.getElementById('day');
                const month = document.getElementById("month");
                const year = document.getElementById("year");
                if (!(validateDate(day.value, month.value, year.value) || errorsArray.find(() => ({ 'id': id })))) {
                    errorsArray.push({
                        'id': id,
                        'message': " invalid"
                    });
                }
                break;
            case "stock", "price":
                if (!(validateMoreOne(input.value) || errorsArray.find(() => ({ 'id': id })))) {
                    errorsArray.push({
                        'id': id,
                        'message': " is incorrect. At least 6 digits are needed"
                    });
                }
                break;

        }

    });

    let errors = createErrors(errorsArray);

    if (errors != null)
        return errors;
    else
        return false;
}

function createErrors(errorsArray) {

    if (errorsArray.length > 0) {
        const errors = document.createElement('ul');
        errors.id = "errors";
        errors.className = "alert";
        errorsArray.forEach((o) => {
            const li = document.createElement('li');
            li.textContent = o.id + o.message;
            errors.appendChild(li);
        });
        return errors;
    }

}

function validateDate(day, month, year) {

    let daymoReg = new RegExp("^\d{1,2}");
    let yearReg = new RegExp("^\d{4}");

    if (daymoReg.test(day) && yearReg.test(year) && daymoReg.test(month))
        return false;

    if (year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    if (!(day > 0 && day <= monthLength[month - 1]))
        return false;

    let d = new Date(year, month - 1, day);
    return d <= Date.now();

}

function validateMaxSize(element) {
    return element.length < 255;
}

function validateMinSize(element) {
    return element.length > 6;
}

function validateMoreOne(element) {
    return element >= 1;
}