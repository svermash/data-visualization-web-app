const loggedOut = document.querySelectorAll('.logged-out');
const loggedIn = document.querySelectorAll('.logged-in');

const setupUI = (user)=>{
    if(user){
        loggedIn.forEach(item=> item.style.display='block');
        loggedOut.forEach(item=> item.style.display='none');

        
    }else{
        loggedIn.forEach(item=> item.style.display='none');
        loggedOut.forEach(item=> item.style.display='block');

    }
}

const btnsignUP = document.querySelector('.navBTN-signUP');
const loginBTN = document.querySelector('.navBTN-login');
const logout = document.querySelector('.navBTN-logout');



const Swrapper = document.querySelector('.Swrapper');
const wrapper = document.querySelector('.wrapper');

const SiconClose=document.querySelector('.Sicon-close');
const iconClose=document.querySelector('.icon-close');

const signUPform = document.querySelector('#signUP-form');
const loginform = document.querySelector('#login-form');



btnsignUP.addEventListener('click', () => {
    Swrapper.classList.add('active-popup');
    wrapper.classList.remove('active-popup');
    btnsignUP.style.border = '2px solid black'; 
    btnsignUP.style.color = 'white'; 
    btnsignUP.style.backgroundColor = 'blue'; 

    loginBTN.style.color = '';
    loginBTN.style.backgroundColor = ''; 

});

SiconClose.addEventListener('click', () => {
    Swrapper.classList.remove('active-popup');
    btnsignUP.style.color = '';
    btnsignUP.style.backgroundColor = ''; 
});

signUPform.addEventListener('submit', () => {
    Swrapper.classList.remove('active-popup');
    btnsignUP.style.color = '';
    btnsignUP.style.backgroundColor = ''; 
});



loginBTN.addEventListener('click', () => {
    wrapper.classList.add('active-popup');
    Swrapper.classList.remove('active-popup');
    loginBTN.style.border = '2px solid black'; 
    loginBTN.style.color = 'white'; 
    loginBTN.style.backgroundColor = 'blue'; 

    btnsignUP.style.color = '';
    btnsignUP.style.backgroundColor = ''; 
//
    signUPform.classList.add('inactive');
    loginform.classList.remove('inactive');
//
});

iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
    loginBTN.style.color = '';
    loginBTN.style.backgroundColor = ''; 
});

loginform.addEventListener('submit', () => {
    wrapper.classList.remove('active-popup');
    loginBTN.style.color = '';
    loginBTN.style.backgroundColor = ''; 
});

