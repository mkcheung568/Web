const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');


if(bar){
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if(bar){
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    });
}

// add to cart function

// document.addEventListener("DOMContentLoaded", displayCart);



function displayCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const tbody = document.querySelector("#cart tbody");

    // Clear the table body before displaying the cart
    tbody.innerHTML = '';

    if (cart.length) {
        cart.forEach(product => {
            const row = document.createElement("tr");
            const subtotal = product.price * product.quantity;

            row.innerHTML = `
                <td><a href="#" class="remove-product" data-product-id="${product.id}" data-product-color="${product.color}"><i class="fa fa-times-circle"></i></a></td>
                <td><img src="${product.image}" alt="${product.name}"></td>
                <td>${product.name}</td>
                <td>${product.color}</td>
                <td>$${product.price.toLocaleString()}</td>
                <td><input class="quantity-input" type="number" min="1" max="10" value="${product.quantity}"></td>
                <td class="subtotal">$${subtotal.toLocaleString()}</td>
            `;

            tbody.appendChild(row);

            const removeButton = row.querySelector(".remove-product");
            removeButton.addEventListener("click", removeProductFromCart);

        
            const quantityInput = row.querySelector(".quantity-input");
            quantityInput.addEventListener("change", () => {
                updateSubtotal(event);
                applyCoupon();
            });
            
        });
    }
    updateCartTotal();
    document.getElementById("apply-coupon").addEventListener("click", applyCoupon);
    updateCheckoutButton();    

}



function removeProductFromCart(event) {
    event.preventDefault();

    const productId = event.target.parentElement.dataset.productId;
    const productColor = event.target.parentElement.dataset.productColor;

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter(product => !(product.id === productId && product.color === productColor));

    localStorage.setItem("cart", JSON.stringify(cart));

    // Refresh the cart display
    displayCart();
}


function applyCoupon() {
    const couponInput = document.getElementById("coupon-input");
    const couponCode = couponInput.value.trim();
    const discountCell = document.querySelector("#subtotal table tr:nth-child(2) td:last-child");
    let discount = 0;

    if (couponCode === "TECHLIVE1") {
        discount = 500;
    }
    discountCell.textContent = `$${discount}`;

    // Update the total after applying the discount
    updateCartTotal(discount);
}




function updateSubtotal(event) {
    const inputElem = event.target;
    const row = inputElem.closest("tr");
    const productId = row.querySelector(".remove-product").dataset.productId;
    const productColor = row.querySelector(".remove-product").dataset.productColor;
    const newQuantity = parseInt(inputElem.value, 10);
    const priceCell = row.querySelector("td:nth-child(5)");
    const priceText = priceCell.textContent.substr(1).replace(',', '');
    const price = parseFloat(priceText);

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const productIndex = cart.findIndex(product => product.id === productId && product.color === productColor);

    if (productIndex !== -1) {
        cart[productIndex].quantity = newQuantity;
        localStorage.setItem("cart", JSON.stringify(cart));

        // Update the subtotal display
        const subtotalCell = row.querySelector(".subtotal");
        const newSubtotal = price * newQuantity;
        subtotalCell.textContent = `$${newSubtotal.toLocaleString()}`;
    }
    updateCartTotal();

}



// Modify the updateCartTotal function to accept a discount parameter
function updateCartTotal(discount = 0) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartAllTotal = calculateCartAllTotal(cart);
    const total = cartAllTotal - discount;

    const cartAllTotalCell = document.querySelector("#subtotal table tr:first-child td:last-child");
    const totalCell = document.querySelector("#subtotal table tr:last-child td:last-child");

    cartAllTotalCell.textContent = `$${cartAllTotal.toLocaleString()}`;
    totalCell.textContent = `$${total.toLocaleString()}`;

    // Store the total value in localStorage
    localStorage.setItem("cartTotal", total);
}


// Function to calculate cart all total value
function calculateCartAllTotal(cart) {
  return cart.reduce((acc, product) => {
    return acc + product.price * product.quantity;
  }, 0);
}



function updateCheckoutButton() {
    const checkoutBtn = document.getElementById('checkout-btn');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        checkoutBtn.disabled = true;
        checkoutBtn.classList.add('btn-secondary');
        checkoutBtn.classList.remove('btn-primary');
    } else {
        checkoutBtn.disabled = false;
        checkoutBtn.classList.add('btn-primary');
        checkoutBtn.classList.remove('btn-secondary');
    }
    checkoutBtn.addEventListener('click', () => {
        window.location.href = 'checkout.php';
    });
}

