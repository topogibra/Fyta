
document.getElementById('registerForm').addEventListener('submit', add_date);

function add_date(event) {
  // event.preventDefault();
  let form = event.target;
  console.log(event)
  let day = document.getElementById('day').value;
  let month = document.getElementById('month').value;
  let year = document.getElementById('year').value;
  let birthday = year + '-' + month + '-' + day;
  form.birthday.value = birthday;
  console.log(event.target)
  
}
