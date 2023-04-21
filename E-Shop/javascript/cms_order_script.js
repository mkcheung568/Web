
document.getElementById('add-order').addEventListener('click', function () {
  document.getElementById('order-form-container').style.display = 'block';
});

document.getElementById('cancel').addEventListener('click', function () {
  document.getElementById('order-form-container').style.display = 'none';
});

document.getElementById('order-form').addEventListener('submit', function (event) {
  event.preventDefault();

  const customerName = document.getElementById('customerName').value;
  const email = document.getElementById('email').value;
  const productName = document.getElementById('productName').value;
  const quantity = document.getElementById('quantity').value;
  const totalCost = document.getElementById('totalCost').value;
  const paymentMethod = document.getElementById('paymentMethod').value;
  const shippingAddress = document.getElementById('shippingAddress').value;
  const status = document.getElementById('status').value;

  if (customerName && email && productName && quantity && totalCost && paymentMethod && shippingAddress && status) {
    const tbody = document.querySelector('#order-table tbody');
    let existingRow = tbody.querySelector(`tr[data-email="${email}"]`);

    if (existingRow) {
      const newRow = document.createElement('tr');
      newRow.dataset.email = email;

      newRow.innerHTML = `
        <td>${customerName}</td>
        <td>${email}</td>
        <td>${productName}</td>
        <td>${quantity}</td>
        <td>$${parseFloat(totalCost).toFixed(2)}</td>
        <td>${paymentMethod}</td>
        <td>${shippingAddress}</td>
        <td>${status}</td>
        <td><button class="remove-order">Remove</button></td>
      `;

      existingRow.insertAdjacentElement('afterend', newRow);
    } else {
      const newRow = document.createElement('tr');
      newRow.dataset.email = email;

      newRow.innerHTML = `
        <td>${customerName}</td>
        <td>${email}</td>
        <td>${productName}</td>
        <td>${quantity}</td>
        <td>$${parseFloat(totalCost).toFixed(2)}</td>
        <td>${paymentMethod}</td>
        <td>${shippingAddress}</td>
        <td>${status}</td>
        <td><button class="remove-order">Remove</button></td>
      `;

      tbody.appendChild(newRow);
    }

    document.getElementById('order-form-container').style.display = 'none';
    event.target.reset();
  }
});

document.querySelector('#order-table tbody').addEventListener('click', function (event) {
  if (event.target.classList.contains('remove-order')) {
    event.target.closest('tr').remove();
  }
});
