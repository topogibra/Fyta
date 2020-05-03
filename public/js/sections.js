import { removeAll } from './utils.js'

export async function buildPage(section){
    const contentContainer = document.querySelector('.profile > .row > .col-md-9');

    removeAll(contentContainer);

    const header = document.createElement('h3');
    header.textContent = section.name;
    contentContainer.appendChild(header);
    const content = await section.action();
    contentContainer.appendChild(content);
}

export default function buildSections(sections){
    const listGroup = document.querySelector('ul.list-group.list-group-flush');

    sections.forEach((section, i) => {
        const item = document.createElement('li');
        item.className = "list-group-item";
        const reference = document.createElement('a');
        reference.className = "badge badge-light";
        reference.textContent = section.name;
        if(section.id){
            reference.id = section.id
        }

        reference.addEventListener('mousedown', async () => {
            buildPage(section);
        });
        item.appendChild(reference);
        listGroup.appendChild(item);

        if(i == 0) reference.dispatchEvent(new Event('mousedown'));
    });
}