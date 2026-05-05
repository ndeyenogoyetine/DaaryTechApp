//Récupération des champs du formulair
const nomInput = document.getElementById("nom");
const emailInput = document.getElementById("email");
const sujetInput = document.getElementById("sujet");
const messageInput = document.getElementById("message");
const frmContact = document.getElementById("frmContact");
const btnContactSubmit = frmContact.querySelector("button[type='submit']");

let isNameValid = false;
let isEmailValid = false;
let isSujetValid = false;
let isMessageValid = false;


//Désactive le button de soumission par defaut
btnContactSubmit.disabled = true;
//Permet d'afficher ou masquer les message d'erreur

function showError(input, message) {
    const baliseP = input.closest(".form-group").querySelector(".error-message");

    if (message) {
        baliseP.textContent = message;
        input.classList.add("is-invalid");
        baliseP.style.color = "brown";
        baliseP.style.fontWeight = "bold";
    } else {
        baliseP.textContent = "";
        input.classList.remove("is-invalid");
    }
}

// Validation du nom 
nomInput.addEventListener("input", () => {
    const nom = nomInput.value.trim();
    const nameValidator = Validator.nameValidator("Le nom", 5, 40, nom);

    if (nameValidator) {
        showError(nomInput, nameValidator.message);
        isNameValid = false; //  false si erreur
    }
    else {
        showError(nomInput, "");
        isNameValid = true; //  true si valide
    }
     checkFormValidaty();
});

// Validation du champs  email à la saisie
emailInput.addEventListener("input", () => {
    const email = emailInput.value.trim();
    const emailValidator = Validator.emailValidator("L'email", email);
    if (emailValidator) {
        showError(emailInput, emailValidator.message);
        isEmailValid = false;
    }
    else {
        showError(emailInput, "");
        isEmailValid = true; // true si valide
    }
     checkFormValidaty();
});

// Validation du champs  sujet à la saisie
sujetInput.addEventListener("input", () => {
    const sujet = sujetInput.value.trim();
    const sujetValidator = Validator.nameValidator("Le sujet", 5, 50, sujet);
    if (sujetValidator) {
        showError(sujetInput, sujetValidator.message);
        isSujetValid = false; // false si erreur
    }
    else {
        showError(sujetInput, "");
        isSujetValid = true; //  true si valide
    }
   checkFormValidaty();
});

// Validation du champs  message à la saisie
messageInput.addEventListener("input", () => {
    const message = messageInput.value.trim();
    const messageValidator = Validator.nameValidator("Le message ", 20, 500, message);
    if (messageValidator) {
        showError(messageInput, messageValidator.message);
        isMessageValid = false;
    }
    else {
        showError(messageInput, "");
        isMessageValid = true; //  true si valide
    }
    checkFormValidaty();
});

// Active le bouton de validation si touts les champs sont valides
function checkFormValidaty()
{
    if (isNameValid 
       && isEmailValid 
       && isSujetValid 
       && isMessageValid )
    {
           btnContactSubmit.removeAttribute("disabled");
    }    
}

