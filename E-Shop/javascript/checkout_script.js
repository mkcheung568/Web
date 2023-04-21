// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over the forms and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      } else {
        // Call the showPaymentAlert function if the form is valid
        // event.preventDefault() // Prevent the default form submission
        // showPaymentAlert(form)
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

function showPaymentAlert(form) {
  alert('Your payment has finished, and we will ship the product to you within 7 days')
  form.reset() // Clear the form content
  window.location.href = 'index.php'
  localStorage.removeItem("cart"); // Clear the cart
  localStorage.removeItem("cartTotal"); // Clear the cart total
}

const bar = document.getElementById('bar')
const close = document.getElementById('close')
const nav = document.getElementById('navbar')

if (bar) {
  bar.addEventListener('click', () => {
    nav.classList.add('active')
  })
}

if (close) {
  close.addEventListener('click', () => {
    nav.classList.remove('active')
  })
}

// document.addEventListener("DOMContentLoaded", () => {
//   const cartTotal = localStorage.getItem("cartTotal");
//   if (cartTotal) {
//     document.getElementById("checkout-total").textContent = `$${cartTotal}`;
//   }
// });