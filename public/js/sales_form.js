import { validateRequirements, createErrors } from "./http_error.js";
import request from "./request.js";
import { removeAll } from "./utils.js";
import { buildPagination } from "./pagination.js";

const dBegin = document.querySelector("#begin");
const dEnd = document.querySelector("#end");

let errors;
const form = document.querySelector("#submit-button");
let changed = false;

function verifyInput(inputList) {
    let valErrors = validateRequirements(inputList);
    if (dBegin.value > dEnd.value) {
        const li = document.createElement("li");
        li.textContent = "Begin date must be before End date";
        if (valErrors) valErrors.appendChild(li);
        else
            valErrors = createErrors([
                {
                    id: "Begin date",
                    message: " must be before End date",
                },
            ]);
    } else if (changed && (new Date(dBegin.value) < new Date().setHours(0,0,0,0) || new Date(dEnd.value) < new Date().setHours(0,0,0,0))) {
        const li = document.createElement("li");
        li.textContent = "Can't choose a date that has already passed";
        if (valErrors) valErrors.appendChild(li);
        else
            valErrors = createErrors([
                {
                    id: "A date chosen",
                    message: " can't have passed",
                },
            ]);
    }

    errors && errors.remove();
    return valErrors;
}

const availableProducts = async (pg = 1) => {
    const legend = document.querySelector("#products-sales legend");
    const productList = document.querySelector("#products-list");
    if (!dBegin.value || !dEnd.value) {
        removeAll(productList);
        legend.textContent = "Select a date range to view eligible products";
        return;
    }
    const valErrors = verifyInput(["begin", "end"], changed);
    if (valErrors) {
        removeAll(productList);
        form.prepend(valErrors);
        errors = valErrors;
    } else {
        legend.textContent = "Select the eligible products";

        const saleID = document.querySelector("#sale-id").value;
        const formContent = {
            begin: dBegin.value,
            end: dEnd.value,
            page: pg,
        };
        if (saleID != -1) formContent.id = saleID;

        const data = await request({
            url: "/manager/sale/products",
            method: "GET",
            content: formContent,
        });

        const container = buildProductsList(data.products);
        container.appendChild(
            buildPagination(pg, data.pages, (page) => {
                availableProducts(page);
            })
        );
    }
};

dBegin.addEventListener("change", () => {
    changed = true;
    availableProducts();
});
dEnd.addEventListener("change", () => {
    changed = true;
    availableProducts();
});

document.querySelector("#sales-form").addEventListener("submit", (event) => {
    const valErrors = verifyInput(["begin", "end", "percentage"], changed);
    if (valErrors) {
        form.prepend(valErrors);
        event.preventDefault();
        errors = valErrors;
    }

    const list = document.querySelector("#products-list");
    const items = list.children;
    let productsApplied = [];
    for (let i = 0; i < items.length; i++) {
        const checkbox = items[i].querySelector(".custom-control-input");
        if (checkbox && checkbox.checked)
            productsApplied.push(parseInt(checkbox.id));
    }

    event.target.products.value = productsApplied.join(",");
});

const buildProductsList = (products) => {
    const list = document.querySelector("#products-list");
    removeAll(list);

    products.forEach((product) => {
        const item = document.createElement("li");
        item.className = "list-group-item";
        const row = document.createElement("div");
        row.className = "row table-entry justify-content-between";
        const checkboxWrapper = document.createElement("div");
        checkboxWrapper.className = "col custom-control custom-checkbox";
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "custom-control-input";
        checkbox.id = product.id;
        checkbox.checked = product.applied;
        const label = document.createElement("label");
        label.className = "custom-control-label";
        label.htmlFor = product.id;
        label.textContent = product.name;
        checkboxWrapper.id = "productname";
        checkboxWrapper.appendChild(checkbox);
        checkboxWrapper.appendChild(label);
        const imgWrapper = document.createElement("div");
        imgWrapper.className = "col entry-img";
        const img = document.createElement("img");
        img.src = "/img/" + product.img;
        img.alt = product.alt;
        imgWrapper.id = "image";
        imgWrapper.appendChild(img);
        const price = document.createElement("div");
        price.id = "price";
        price.className = "col";
        price.textContent = product.price + "€";
        row.appendChild(checkboxWrapper);
        row.appendChild(imgWrapper);
        row.appendChild(price);
        item.appendChild(row);
        list.appendChild(item);
    });

    if (products.length == 0) {
        list.textContent = "No products available to this sale!";
    }

    return list;
};

if (dBegin.value && dEnd.value) availableProducts();
