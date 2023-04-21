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

var MainImg = document.getElementById("MainImg");
var SmallImg = document.getElementsByClassName("small-img");

SmallImg[0].onclick = function(){
    MainImg.src = SmallImg[0].src;
}
SmallImg[1].onclick = function(){
    MainImg.src = SmallImg[1].src;
}
SmallImg[2].onclick = function(){
    MainImg.src = SmallImg[2].src;
}
SmallImg[3].onclick = function(){
    MainImg.src = SmallImg[3].src;
}

//for ip14.html

// document.getElementById("add-to-cart-btn").addEventListener("click", addToCart);

function addToCart() {
    const productId = this.dataset.productId;
    const color = document.getElementById("color-select").value;
    const quantity = parseInt(document.getElementById("quantity-input").value, 10);

    const productData = {
        ip14: {
            name: "iPhone 14",
            price: 6899,
            image: "../image/product/phone/Apple/ip14.png"
        },
        galaxys23: {
            name: "Galaxy S23",
            price: 5899,
            image: "../image/product/phone/Samsung/galaxy-s23.png"
        },
        ipadair:{
            name: "iPad Air",
            price: 4799,
            image: "../image/product/tablet/Apple/ipad-air.png"
        },
        tabs7:{
            name: "Tab S7 FE",
            price: 4988,
            image: "../image/product/tablet/samsung/galaxy-tab-s7-fe-black.png"
        },
        macbookair:{
            name: "MacBook Air M2",
            price: 9499,
            image: "../image/product/laptop/Apple/MacBook-Air-M2.png"
        },
        zenbooks13:{
            name: "ZenBook S 13 OLED",
            price: 9998,
            image: "./image/product/laptop/Asus/zenbook-s-blue.png"
        },

    };

    const product = {
        id: productId,
        ...productData[productId],
        color: color,
        quantity: quantity
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProductIndex = cart.findIndex(p => p.id === productId && p.color === color);

    if (existingProductIndex !== -1) {
        cart[existingProductIndex].quantity += quantity;
    } else {
        cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Your product has been added to the shopping cart");
    // Comment out the following line if you don't want to redirect the user to the cart page
  //  window.location.href = "cart.html";
}