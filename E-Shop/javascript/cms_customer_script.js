document.getElementById('add-customer').addEventListener('click', function () {
  document.getElementById('customer-form-container').style.display = 'block';
});

document.getElementById('cancel').addEventListener('click', function () {
  document.getElementById('customer-form-container').style.display = 'none';
});

// document.getElementById('customer-form').addEventListener('submit', function(event) {
//   event.preventDefault();

//   const givenName = document.getElementById('givenName').value;
//   const surname = document.getElementById('surname').value;
//   const nickname = document.getElementById('nickname').value;
//   const password = document.getElementById('password').value;
//   const email = document.getElementById('email').value;
//   const phone = document.getElementById('phone').value;
//   const gender = document.getElementById('gender').value;

//   if (givenName && surname && nickname && email && phone && gender && password) {
//       const row = document.createElement('tr');
//       const maskedPassword = maskPassword(password);

//       row.innerHTML = `
//           <td>${givenName}</td>
//           <td>${surname}</td>
//           <td>${nickname}</td>
//           <td>${maskedPassword}</td>
//           <td>${email}</td>
//           <td>${phone}</td>
//           <td>${gender}</td>
//           <td><button class="remove-user">Remove</button></td>
//       `;


//       document.querySelector('#customer-table tbody').appendChild(row);
//       document.getElementById('customer-form-container').style.display = 'none';
//       event.target.reset();
//   }
// });

document.querySelector('#customer-table tbody').addEventListener('click', function (event) {
  if (event.target.classList.contains('remove-user')) {
    event.target.closest('tr').remove();
  }
});

function maskPassword(password) {
  const maskedPassword = password.replace(/./g, '*');
  return maskedPassword;
}


function checkRegister() {
  if (document.getElementById('password').value != document.getElementById('confirm_password').value) {
    alert("Password and Confirm Password Field do not match  !!");
    return false;
  }
  return true;
}