//Récupération des champs du formulair
const nomInput = document.getElementById("user-nom");
const adresseInput = document.getElementById("user-adresse");
const telephoneInput = document.getElementById("user-telephone");
const emailInput = document.getElementById("user-email");
const photoInput = document.getElementById("user-photo");
const roleInput = document.getElementById("user-role");
const frmAddUser = document.getElementById("addUserFrom");
const btnAddSubmit = frmAddUser.querySelector("button[type='submit']");

let isNameValid = false;
let isAdresseValid = false;
let isTelephoneValid = false;
let isEmailValid = false;
let isPhotoValid = false;
let isRoleValid = false;


//Désactive le button de soumission par defaut
btnAddSubmit.disabled = false;
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

// Validation du nom à la saisie
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
    // checkFormValidaty();
});

// Validation du champs  Adresse à la saisie
adresseInput.addEventListener("input", () => {
    const adresse = adresseInput.value.trim();
    const adresseValidator = Validator.adresseValidator("L'adresse", 5, 50, adresse);
    if (adresseValidator) {
        showError(adresseInput, adresseValidator.message);
        isAdresseValid = false; // false si erreur
    }
    else {
        showError(adresseInput, "");
        isAdresseValid = true; //  true si valide
    }
    // checkFormValidaty();
});

// Validation du champs  telephone à la saisie
telephoneInput.addEventListener("input", () => {
    const telephone = telephoneInput.value.trim();
    const telephoneValidator = Validator.phoneValidator("Le numéro de télephone", 9, 17, telephone);
    if (telephoneValidator) {
        showError(telephoneInput, telephoneValidator.message);
        isTelephoneValid = false;
    }
    else {
        showError(telephoneInput, "");
        isTelephoneValid = true; //  true si valide
    }
    // checkFormValidaty();
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
    // checkFormValidaty();
});

// Validation du champs  photo à la selection
photoInput.addEventListener("change", () => {
    const file = photoInput.files[0];
    if (!file) {
        showError(photoInput, "La photo est obligatoire.");
        isPhotoValid = false; //  false si pas de fichier
    }
    else if(!file.type.startsWith("image/")) {
        showError(photoInput, "Le fichier doit ètre une image.");
        isPhotoValid = false; //  false si pas une image
    }
    else {
        showError(photoInput, "");
        isPhotoValid = true; // true si valide
    }
    // checkFormValidaty();
});


// Validation du champs  role
roleInput.addEventListener("change", () => {
    if (roleInput.value === "") {
        showError(roleInput, "Veuillez slectionner  un role.");
        isRoleValid = false; // false si pas de role
    }
    else {
        showError(roleInput, "");
        isRoleValid = true; //  true si valide
    }
        // checkFormValidaty();

});


//Active le bouton de validation si touts les champs sont valides
// function checkFormValidaty()
// {
//     // if (isNameValid 
//     //    && isAdresseValid 
//     //    && isTelephoneValid 
//     //    && isEmailValid 
//     //    && isPhotoValid 
//     //    && isRoleValid ) {
        
//     //        btnAddSubmit.removeAttribute("disabled");
//     // }
       
    
// }

//  Reset déplacé hors de checkFormValidaty
document.querySelector("button[type='reset']").addEventListener("click", () => {
    [nomInput, adresseInput, telephoneInput, emailInput, photoInput, roleInput].forEach(input => {
        showError(input, "");
    });
    isNameValid = false;
    isAdresseValid = false;
    isTelephoneValid = false;
    isEmailValid = false;
    isPhotoValid = false;
    isRoleValid = false;
    btnAddSubmit.disabled = true;
});

frmAddUser.addEventListener("reset", () =>{
     btnAddSubmit.disabled = false;
 });