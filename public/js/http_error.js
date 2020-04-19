export function buildErrorMessage(error,message) {
    const container = document.createElement('div');
    container.className = 'container d-flex h-100 align-items-center justify-content-center';
    const msgBox = document.createElement('div');
    msgBox.className = "alert";
    msgBox.id = "errors";
    msgBox.textContent = 'Error ' + error + ': ' + message;
    container.appendChild(msgBox);

    return container
}