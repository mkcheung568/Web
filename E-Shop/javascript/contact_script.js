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

function validatingEmail(email) {
  const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
  return emailRegex.test(email);
}

function clearemail() {
    document.getElementById('newsletterEmailInput').value = '';
  }

document.getElementById('subscribeButton').addEventListener('click', function() {
const newsletterEmailInput = document.getElementById('newsletterEmailInput');
const emailNewsLetter = newsletterEmailInput.value.trim();
  if (emailNewsLetter) {
    if (validatingEmail(emailNewsLetter)) {
      alert(`The email (${emailNewsLetter}) has subscribed to our newsletter, thank you!`);
      clearemail();
    } else {
      alert('Please enter a valid email address.');
    }
  } else {
    alert('Please enter your email before subscribing.');
  }
});





//for the contact form1

function showModal() {
    document.getElementById('confirmationModal').style.display = 'block';
  }
  
  function hideModal() {
    document.getElementById('confirmationModal').style.display = 'none';
  }
  
  function clearForm() {
    document.getElementById('nameInput').value = '';
    document.getElementById('emailInput').value = '';
    document.getElementById('subjectInput').value = '';
    document.getElementById('messageInput').value = '';
  }
  
  document.getElementById('submitContactForm').addEventListener('click', function() {
    const name = document.getElementById('nameInput').value;
    const email = document.getElementById('emailInput').value;
    const subject = document.getElementById('subjectInput').value;
    const message = document.getElementById('messageInput').value;
  
    if (validatingEmail(email)) {
      document.getElementById('confirmName').innerText = name;
      document.getElementById('confirmEmail').innerText = email;
      document.getElementById('confirmSubject').innerText = subject;
      document.getElementById('confirmMessage').innerText = message;
      showModal();
    } else {
      alert('Please enter a valid email address.');
    }
  });
  
  document.getElementById('confirmButton').addEventListener('click', function() {
    hideModal();
    alert('Your message has been submitted, and we will contact you as soon as possible.');
    clearForm(); // Call the clearForm function here to clear the form content
  });
  
  document.getElementById('cancelButton').addEventListener('click', function() {
    hideModal();
  });