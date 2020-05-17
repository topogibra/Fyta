import { buildModal, buildConfirmation, createSaleColumn, removeAll } from "./utils.js";
import request from "./request.js";
import { buildErrorMessage } from "./http_error.js";

export default function buildSales(discounts) {
    const container = document.createElement("div");
    container.className = "container";
    const header = document.createElement("div");
    header.className = "row header";

    ["Edit", "Discount (%)", "Begins", "Ends", "Delete"].forEach((element) => {
        const heading = document.createElement("div");
        heading.className = "col-md-2";
        heading.textContent = element;
        header.appendChild(heading);
    });

    container.appendChild(header);
    let errors;
    discounts.forEach((discount, i) => {
        const row = document.createElement("div");
        row.id = `discount-${i}`;
        row.className = "row table-entry justify-content-between";
        const href = document.createElement("a");
        href.href = "/manager/sales/" + discount.id;
        href.className = "col-md-2 col-6 name text-center";
        const edit = document.createElement("i");
        edit.className = "fas fa-edit";
        href.appendChild(edit);
        row.appendChild(href);
        row.appendChild(createSaleColumn(discount.percentage, "percentage"));
        row.appendChild(createSaleColumn(discount.begin, "begin"));
        row.appendChild(createSaleColumn(discount.end, "end"));
        const col = document.createElement("button");
        col.classList.add(...["col-md-2", "col-6", "delete"]);
        col.type = "button";
        col.setAttribute("data-toggle", "modal");
        const deleteId = `delete-${discount.id}`;
        col.setAttribute("data-target", `#${deleteId}`);
        const del = document.createElement("i");
        del.className = "fas fa-trash";
        const modal = buildModal(
            "Are you sure you want to delete?",
            buildConfirmation(async () => {
                try {
                    const result = await request({
                        url: `/manager/sales/400`,
                        method: "DELETE",
                        content: {},
                    });
                    if (result.status != 200) throw {status: result.status, message: "Failed to delete sale, try again later."};
                    row.remove();
                    return result;
                } catch (e) {
                    $(`#${deleteId}`).modal("hide");
                    container.appendChild(buildErrorMessage(e.status, e.message));
                }
            }),
            deleteId
        );

        if (errors) {
          return buildErrorMessage(errors.status, errors.message);   
        }

        container.appendChild(modal);
        col.appendChild(del);
        row.appendChild(col);
        container.appendChild(row);
    });

    const row = document.createElement("div");
    row.className = "row justify-content-center";

    const createCol = document.createElement("div");
    createCol.className = "col-4  mr-0 ";
    const createButton = document.createElement("a");
    createButton.className = "btn createBtn rounded-0 btn-lg shadow-none";
    createButton.setAttribute("role", "button");
    createButton.textContent = "Create";
    createButton.id = "sales-button";
    createButton.href = "manager/sale";
    createCol.appendChild(createButton);

    row.appendChild(createCol);
    container.appendChild(row);

    return container;
}
