

var LoginForm = document.getElementById("LoginForm");
var RegForm = document.getElementById("RegForm");
var Indicator = document.getElementById("Indicator");


function initializeForms() {
    login();
  }

initializeForms();
  

function login(){
    LoginForm.style.transform = "translateX(300px)";
    RegForm.style.transform = "translateX(300px)";
    Indicator.style.transform = "translateX(0px)";
}

function register(){
    LoginForm.style.transform = "translateX(0px)";
    RegForm.style.transform = "translateX(0px)";
    Indicator.style.transform = "translateX(100px)";

}



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

function checkRegister() {
    if(document.getElementById('password').value != document.getElementById('confirm_password').value) {
        alert("Password and Confirm Password Field do not match  !!");
        return false;
    }
    return true;
}