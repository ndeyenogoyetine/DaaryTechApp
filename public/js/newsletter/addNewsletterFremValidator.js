//Récupération des champs du formulair

const emailNewsletterInput = document.getElementById("newsletter-email");
const frmAddNewsletter = document.getElementById("addNewsletterFrom");
const btnNewsletterSubmit = frmAddNewsletter.querySelector("button[type='submit']");

let isEmailNewsletterValid = false;



//Désactive le button de soumission par defaut
btnNewsletterSubmit.disabled = false;
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


// Validation du champs  email à la saisie
emailNewsletterInput.addEventListener("input", () => {
    const email = emailNewsletterInput.value.trim();
    const emailValidator = Validator.emailValidator("L'email", email);
    if (emailValidator) {
        showError(emailNewsletterInput, emailValidator.message);
        isEmailNewsletterValid = false;
    }
    else {
        showError(emailNewsletterInput, "");
        isEmailNewsletterValid = true; // true si valide
    }
    checkFormValidaty();
});




//Active le bouton de validation si touts les champs sont valides
function checkFormValidaty()
{
    if (isEmailNewsletterValid) {
           btnNewsletterSubmit.removeAttribute("disabled");
    }    
    isEmailNewsletterValid = false;
    btnNewsletterSubmit.disabled = false;
}


  