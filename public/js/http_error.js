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
        if (!input.value) {
            errorsArray.push({
                'id': id,
                'message': " is required"
            });
        }
        if (id == "username" || id == "email" || id == "address" || id == "deliveryaddress" || id == "billingaddress") {
            if (!(validateMaxSize(input.value) || errorsArray.find(() => ({ 'id': id }))))
                errorsArray.push({
                    'id': id,
                    'message': " to big. Max of 255 caracters"
                });
        } else if (id == "password") {
            if (!(validateMinSize(input.value) || errorsArray.find(() => ({ 'id': id }))))
                errorsArray.push({
                    'id': id,
                    'message': " is incorrect. At least 6 digits are needed"
                });
        } else if (id == "birthday") {
            const day = document.getElementById('day');
            const month = document.getElementById("month");
            const year = document.getElementById("year");
            if (!(validateDate(day.value, month.value, year.value) || errorsArray.find(() => ({ 'id': id }))))
                errorsArray.push({
                    'id': id,
                    'message': " invalid"
                });
        } else if (id == "stock" || id == "price") {
            if (!(validateMoreOne(input.value) || errorsArray.find(() => ({ 'id': id }))))
                errorsArray.push({
                    'id': id,
                    'message': " is incorrect. At least 6 digits are needed"
                });
        }
    });

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
    return false;
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