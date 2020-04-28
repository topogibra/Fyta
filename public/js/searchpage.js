import { buildErrorMessage } from "./http_error.js";
import request from "./request.js";
import { removeAll } from "./utils.js";
import { buildPagination } from "./pagination.js"

//responsiveness
const filter = document.getElementById("filter");

const filtericon = document.querySelector("#filter i");
const filtercontent = document.getElementsByClassName("col-lg-3");

filter.addEventListener("click", (event) => {
  if (filtercontent[0].style.display == "none") {
    filtericon.className = "fas fa-chevron-up";
    filtercontent[0].style.display = "block";
  } else {
    filtericon.className = "fas fa-chevron-down";
    filtercontent[0].style.display = "none";
  }
});

//price range control
const priceinputmin = document.querySelector(
  ".price .price-inputs .min-input input"
);
const priceinputmax = document.querySelector(
  ".price .price-inputs .max-input input"
);
priceinputmin.min = 1;
priceinputmin.max = 99;
priceinputmax.min = 2;
priceinputmax.max = 100;

const pricevaluemin = document.querySelector(".price .price-values .min p");
const pricevaluemax = document.querySelector(".price .price-values .max p");

priceinputmin.value = 1;
priceinputmax.value = 100;
let priceinputminoldvalue = 1;
let priceinputmaxoldvalue = 100;

function priceInputHandler() {
  if (priceinputmin.valueAsNumber >= priceinputmax.valueAsNumber) {
    if (priceinputmin.valueAsNumber == priceinputminoldvalue) {
      priceinputmin.value =
        priceinputmin.valueAsNumber == 1
          ? priceinputmin.valueAsNumber
          : priceinputmax.valueAsNumber - 1;
    } else if (priceinputmax.valueAsNumber == priceinputmaxoldvalue) {
      priceinputmax.value =
        priceinputmax.valueAsNumber == 100
          ? priceinputmax.valueAsNumber
          : priceinputmin.valueAsNumber + 1;
    }
  }

  if (priceinputmin.value == 0) priceinputmin.value = 1;
  if (priceinputmax.value == 0) priceinputmax.value = 100;

  pricevaluemin.textContent = priceinputmin.value + "€";
  pricevaluemax.textContent = priceinputmax.value + "€";
  priceinputminoldvalue = priceinputmin.valueAsNumber;
  priceinputmaxoldvalue = priceinputmax.valueAsNumber;

  searchAction();
}

priceinputmin.addEventListener("input", priceInputHandler, false);

priceinputmax.addEventListener("input", priceInputHandler, false);

//categories control
const catCheckboxes = document.querySelectorAll(
  ".col-lg-3 #categories .custom-control-input"
);
catCheckboxes.forEach((catCheckbox) => {
  catCheckbox.addEventListener("change", () => searchAction());
});

//sizes control
const sizesCheckboxes = document.querySelectorAll(
  ".col-lg-3 #sizes .custom-control-input"
);
sizesCheckboxes.forEach((sizeCheckbox) => {
  sizeCheckbox.addEventListener("change", () => searchAction());
});

//orderBy control
const orderByPrice = document.querySelector("#ordByPrice");
orderByPrice.addEventListener("mousedown", () => searchAction(false));

const orderByPopularity = document.querySelector("#ordByPop");
orderByPopularity.addEventListener("mousedown", () => searchAction());

const orderByPriceMobile = document.querySelector("#priceOrdBy");
orderByPriceMobile.addEventListener("mousedown", () => searchAction(false));

const orderByMatchMobile = document.querySelector("#matchOrdBy");
orderByMatchMobile.addEventListener("mousedown", () => searchAction());

//search control
const searchBar = document.querySelector(".navbar-search");
searchBar.addEventListener("submit", async (event) => {
  event.preventDefault();
  searchAction();
});

function retrieveSearchForm() {
  const queryText = document.querySelector(".navbar-search #query").value;

  const catList = document.querySelector(".col-lg-3 #categories").children;
  const categories = [];
  for (let cat of catList) {
    const checkbox = cat.querySelector(".custom-control-input");
    if (checkbox.checked) {
      const label = cat.querySelector(".custom-control-label");
      categories.push(label.textContent);
    }
  }

  const sizeList = document.querySelector(".col-lg-3 #sizes").children;
  const sizes = [];
  for (let size of sizeList) {
    const checkbox = size.querySelector(".custom-control-input");
    if (checkbox.checked) {
      const label = size.querySelector(".custom-control-label");
      sizes.push(label.textContent);
    }
  }

  const minPrice = document.querySelector(".col-lg-3 .price .price-inputs #min")
    .valueAsNumber;
  const maxPrice = document.querySelector(".col-lg-3 .price .price-inputs #max")
    .valueAsNumber;

  const data = {
    query: queryText,
    tags: categories,
    sizes: sizes,
    minPrice: minPrice,
    maxPrice: maxPrice,
  };

  return data;
}

function buildSearchResults(products) {
  const parentContainer = document.querySelector(".col-lg-8");
  parentContainer.className = "col-lg-8 align-self-start";
  const container = document.createElement("div");
  container.className =
    "row row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-2";

  products.forEach((product) => {
    const productCol = document.createElement("div");
    productCol.classList.add(...["col", "mb-4"]);
    const card = document.createElement("div");
    card.className = "card";
    const imgWrapper = document.createElement("a");
    imgWrapper.className = "img-wrapper";
    imgWrapper.href = "/product/" + product.id;
    const img = document.createElement("img");
    img.className = "card-img-top";
    img.src = "img/" + product.img;
    img.alt = product.alt;
    imgWrapper.appendChild(img);
    card.appendChild(imgWrapper);

    const cardBody = document.createElement("div");
    cardBody.className = "card-body";
    const cardRow = document.createElement("div");
    cardRow.classList.add(...["row", "flex-nowrap", "justify-content-between"]);
    const cardTitle = document.createElement("h5");
    cardTitle.className = "card-title";
    const href = document.createElement("a");
    href.href = "/product/" + product.id;
    href.textContent = product.name;
    cardTitle.appendChild(href);
    cardRow.appendChild(cardTitle);

    const fav = document.createElement("i");
    fav.className = "far fa-star";
    fav.style = "font-size: 1.5em;";
    cardRow.appendChild(fav);
    cardBody.appendChild(cardRow);

    const cardPrice = document.createElement("p");
    cardPrice.className = "card-text";
    cardPrice.textContent = product.price + "€";
    cardBody.appendChild(cardPrice);
    card.appendChild(cardBody);
    productCol.appendChild(card);
    container.appendChild(productCol);
  });

  if (products.length == 0) {
    parentContainer.className = "col-lg-8 align-self-center";
    const row = document.createElement("p");
    row.className = "text-center alert alert-secondary";
    row.textContent = "No results found!";
    container.appendChild(row);
  }

  return container;
}

const searchAction = async (orderByMatch = true) => {
  const content = retrieveSearchForm();
  content.orderByMatch = orderByMatch;
  searchRequest(content);
};

const searchRequest = async (content) => {
  const container = document.querySelector(".col-lg-8");
  removeAll(container);
  try {
    const response = await request({
      url: "/search",
      method: "POST",
      content,
    });

    if (response.status != 200) {
      container.appendChild(
        buildErrorMessage(response.status, response.content)
      );
    } else {

      container.appendChild(buildSearchResults(response))
    };
  } catch (e) {
    container.appendChild(buildErrorMessage(404, "No Results Found!"));
  }
  document.querySelector('.content').appendChild(buildPagination("", {}, 2, 5));
};

const urlParams = new URLSearchParams(window.location.search);
const queryText = urlParams.get("query");
const tag = urlParams.get("section");
const fetchContent = {
  query: queryText,
  tags: tag != null ? [tag] : [],
  orderByMatch: true,
  minPrice: 1,
  maxPrice: 100,
};

if (queryText) {
  const query = document.querySelector(".navbar-search #query");
  query.value = queryText;
}

if (tag) {
  const catList = document.querySelector(".col-lg-3 #categories").children;
  for (let cat of catList) {
    const label = cat.querySelector(".custom-control-label");
    if (tag === label.textContent) {
      const input = cat.querySelector(".custom-control-input");
      input.checked = true;
      break;
    }
  }
}

searchRequest(fetchContent);