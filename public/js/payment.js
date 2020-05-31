const payments = document.getElementsByClassName("payment-img");
const paymentInput = document.getElementById("payment-input");
const form = document.getElementById("payment-form");
const nextbtn = document.getElementById("next-btn");
const payment = document.getElementById("payment-input");
let active = document.querySelector(".active");

nextbtn.addEventListener("click", (evt) => {
  if (payment.value == '') {
    evt.preventDefault();
  }
  
});

for (let element of payments) {
  if (element.parentElement.parentElement.classList.contains('disabled')) {
    continue;
  }
  element.addEventListener("click", (event) => {
    if (active) {
      active.classList.remove("active");
    }
    event.target.parentElement.parentElement.classList.add("active");
    active = event.target.parentElement.parentElement;
    paymentInput.value = event.target.id;
  });
} 