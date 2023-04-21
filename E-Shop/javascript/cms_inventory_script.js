document.getElementById('add-product').addEventListener('click', function() {
  document.getElementById('form-overlay').style.display = 'block';
});

document.getElementById('cancel').addEventListener('click', function() {
  document.getElementById('form-overlay').style.display = 'none';
});

// document.getElementById('product-form').addEventListener('submit', function(event) {
//   event.preventDefault();

//   const productName = document.getElementById('product-name').value;
//   const quantity = document.getElementById('product-quantity').value;
//   const price = document.getElementById('product-price').value;

//   if (productName && quantity && price) {
//       const row = document.createElement('tr');

//       row.innerHTML = `
//           <td>${productName}</td>
//           <td>${quantity}</td>
//           <td>$${parseFloat(price).toFixed(2)}</td> 
//           <td><button class="remove-product">Remove</button></td>
//       `;

//       document.querySelector('#inventory-table tbody').appendChild(row);
//       document.getElementById('form-overlay').style.display = 'none';
//       event.target.reset();
//   }
// });

document.querySelector('#inventory-table tbody').addEventListener('click', function(event) {
  if (event.target.classList.contains('remove-product')) {
      event.target.closest('tr').remove();
  }
});