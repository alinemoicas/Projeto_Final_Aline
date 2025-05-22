const container = document.querySelector('.container');
const registoBtn = document.querySelector('.registo-btn');
const loginBtn = document.querySelector('.login-btn');
//const passBtn = document.getElementById('passBtn');

//var passBtn = document.getElementById('passBtn');

registoBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

/*passBtn.addEventListener('click', function(){
    let password = document.getElementById('password');

    if(password.type == "password"){
        password.type = "text"
        this.style.opacity = "1"
    } else {
        password.type = "password"
        this.style.opacity = ".4"
    }
});*/