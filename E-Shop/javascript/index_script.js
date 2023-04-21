
//for small screen navbar
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


// here is for the subscribe button and newsletter subscription
function validateEmail(email) {
    const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    return emailRegex.test(email);
  }

  document.getElementById('subscribeButton').addEventListener('click', function() {
    const email = document.getElementById('emailInput').value;
    if (email) {
      if (validateEmail(email)) {
        alert(`The email (${email}) has subscribed to our newsletter, thank you!`);
      } else {
        alert('Please enter a valid email address.');
      }
    } else {
      alert('Please enter your email before subscribing.');
    }
  });