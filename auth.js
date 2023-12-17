import { initializeApp} from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
import { getAuth ,
  createUserWithEmailAndPassword, 
  signOut,
  signInWithEmailAndPassword,
  onAuthStateChanged,
} from "https://www.gstatic.com/firebasejs/10.4.0/firebase-auth.js";

const firebaseApp = initializeApp({
  apiKey: "AIzaSyBKOKzKKhQ9X2ujfweLsL2pkIZhnrXDESY",
  authDomain: "scorewalls.firebaseapp.com",
  projectId: "scorewalls",
  storageBucket: "scorewalls.appspot.com",
  messagingSenderId: "689765764303",
  appId: "1:689765764303:web:dd7e591fd4cc0306b47bba",
  measurementId: "G-JX6YTL9L6K"
});

const auth = getAuth(firebaseApp);


//sate change


//

// //signup


const signUPmodal = document.querySelector('#modal-signUP'); 
const loginmodal = document.querySelector('#modal-login'); 

const signUPform = document.querySelector('#signUP-form');
signUPform.addEventListener('submit',(e)=>{
    e.preventDefault();

    const email = signUPform['signUP-email'].value;
    const password = signUPform['signUP-password'].value;

    console.log(email,password)

    createUserWithEmailAndPassword(auth, email, password)
      .then((userCredential) => {
      
        // console.log(userCredential.user)
        signUPform.reset()
        // signUPmodal.style.display = 'none';
      })
      .catch((err)=>{
        console.log(err.message)
      });

})


//login
const loginform = document.querySelector('#login-form');
loginform.addEventListener('submit',(e)=>{
    e.preventDefault();

    const email = loginform['login-email'].value;
    const password = loginform['login-password'].value;

    console.log(email,password)

    signInWithEmailAndPassword(auth, email, password)
      .then((userCredential) => {

        // console.log("user logged in")
        // console.log(userCredential.user)
        loginform.reset();
        // loginmodal.style.display = 'none';

      })
      .catch((err)=>{
        console.log(err.message)
      })
    
})

//logout
const logout = document.querySelector('.navBTN-logout');
logout.addEventListener('click',()=>{

    signOut(auth)
    .then(()=>{
      console.log("sign out")
    })
    .catch((err)=>{
      console.log(err.message)
    })

});



onAuthStateChanged(auth,user=>{
  console.log(auth,user)
  if(user){
    setupUI(user);
  }else{
    setupUI()
  }
});