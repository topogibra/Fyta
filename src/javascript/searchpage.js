let order = document.getElementById('order');
let filter = document.getElementById('filter');

let filtercontent = document.getElementsByClassName("col-lg-2");


filter.addEventListener('click', (event) => {

    if (filtercontent[0].style.display == "none")
        filtercontent[0].style.display = "block";
    else {
        filtercontent[0].style.display = "none";
    }
})

window.addEventListener('resize', (event) => {

    if (window.screen.width > 800) {
        filtercontent[0].style.display = "block";
    }
})