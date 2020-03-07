import { removeAll } from './utils.js'

export default function buildSections(sections){
    const listGroup = document.querySelector('ul.list-group.list-group-flush');
    const contentContainer = document.querySelector('.profile > .row > .col-md-9');

    sections.forEach((section, i) => {
        const item = document.createElement('li');
        item.className = "list-group-item";
        const reference = document.createElement('a');
        reference.className = "badge badge-light";
        reference.textContent = section.name;
        reference.addEventListener('mousedown', () => {
            removeAll(contentContainer);

            const header = document.createElement('h3');
            header.textContent = section.name;
            contentContainer.appendChild(header);
            section.action().forEach(element => contentContainer.appendChild(element));
        });
        item.appendChild(reference);
        listGroup.appendChild(item);

        if(i == 0) reference.dispatchEvent(new Event('mousedown'));
    });
}