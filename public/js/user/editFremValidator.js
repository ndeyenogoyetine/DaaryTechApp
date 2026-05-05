 const editButons = document.querySelectorAll(".btn-edit-user");

    editButons.forEach(button => {
    button.addEventListener("click", () => {
        const id = button.getAttribute("data-id");
        const nom = button.getAttribute("data-nom");
        const adresse = button.getAttribute("data-adresse");
        const telephone = button.getAttribute("data-telephone");
        const email = button.getAttribute("data-email");
        const role = button.getAttribute("data-role");
        const photo = button.getAttribute("data-photo");
        photoChange = photo;

        // Remplir les champs du formulaire
        idEditInput.value = id;
        nomEditInput.value = nom;
        adresseEditInput.value = adresse;
        telephoneEditInput.value = telephone;
        emailEditInput.value = email;
        roleEditInput.value = role;


        // Mettre à jour l'aperçu de la photo
        if (photo) {
            photoEditpreview.src = `../../images/users/${photo}`;
        } 
        else {
            photoEditpreview.src = "";
        }
        
       isNameEditValid 
       
        btnEditSubmit.disabled = !(
       isNameEditValid 
       && isAdresseEditValid 
       && isTelephoneEditValid 
       && isEmailEditValid 
       && photo && photo.type.startsWith("image/") || photoEditpreview.src !== ""
       && isRoleEditValid 
    );
       
    });
});


var idEditInput = document.getElementById("edit-user-id");
var nomEditInput = document.getElementById("edit-user-nom");
var adresseEditInput = document.getElementById("edit-user-adresse");
var telephoneEditInput = document.getElementById("edit-user-telephone");
var emailEditInput = document.getElementById("edit-user-email");
var photoEditInput = document.getElementById("edit-user-photo");
var roleEditInput = document.getElementById("edit-user-role");
var frmEditUser = document.getElementById("editUserFrom");
var btnEditSubmit = frmEditUser.querySelector("button[type='submit']");
var photoEditpreview = document.getElementById("photo-edit-preview");


var isNameEditValid = false;
var isAdresseEditValid = false;
var isTelephoneEditValid = false;
var isEmailEditValid = false;
var isPhotoEditValid = false;
var isRoleEditValid = false;


//Désactive le button de soumission par defaut
btnEditSubmit.disabled = false;
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
nomEditInput.addEventListener("input", () => {
    const nom = nomEditInput.value.trim();
    const nameEditValidator = Validator.nameValidator("Le nom", 5, 40, nom);

    if (nameEditValidator) {
        showError(nomEditInput, nameEditValidator.message);
        isNameEditValid = false; //  false si erreur
    }
    else {
        showError(nomEditInput, "");
        isNameEditValid = true; //  true si valide
    }
    checkFormValidaty();
});

// Validation du champs  Adresse à la saisie
adresseEditInput.addEventListener("input", () => {
    const adresse = adresseEditInput.value.trim();
    const adresseEditValidator = Validator.adresseValidator("L'adresse", 5, 50, adresse);
    if (adresseEditValidator) {
        showError(adresseEditInput, adresseEditValidator.message);
        isAdresseEditValid = false; // false si erreur
    }
    else {
        showError(adresseEditInput, "");
        isAdresseEditValid = true; //  true si valide
    }
    checkFormValidaty();
});

// Validation du champs  telephone à la saisie
telephoneEditInput.addEventListener("input", () => {
    const telephone = telephoneEditInput.value.trim();
    const telephoneEditValidator = Validator.phoneValidator("Le numéro de télephone", 9, 17, telephone);
    if (telephoneEditValidator) {
        showError(telephoneEditInput, telephoneEditValidator.message);
        isTelephoneEditValid = false;
    }
    else {
        showError(telephoneEditInput, "");
        isTelephoneEditValid = true; //  true si valide
    }
    checkFormValidaty();
});

// Validation du champs  email à la saisie
emailEditInput.addEventListener("input", () => {
    const email = emailEditInput.value.trim();
    const emailEditValidator = Validator.emailValidator("L'email", email);
    if (emailEditValidator) {
        showError(emailEditInput, emailEditValidator.message);
        isEmailEditValid = false;
    }
    else {
        showError(emailEditInput, "");
        isEmailEditValid = true; // true si valide
    }
    checkFormValidaty();
});

 // Validation du champs photo à la selection
photoEditInput.addEventListener("change", () => {
    const file = photoEditInput.files[0];

    if (!file && !photoEditpreview.src) {
        showErrorEdit(photoEditInput, "La photo est obligatoire.");
    }
    else if (!file.type.startsWith("image/")) {
        showErrorEdit(photoEditInput, "Le fichier doit être une image.");
    }
    else {
   //     showErrorEdit(photoEditInput, "");
    }
    checkFormValidatyEdit();
});


// Validation du champs  role
roleEditInput.addEventListener("change", () => {
    if (roleEditInput.value === "") {
        showError(roleEditInput, "Veuillez slectionner  un role.");
        isRoleEditValid = false; // false si pas de role
    }
    else {
        showError(roleEditInput, "");
        isRoleEditValid = true; //  true si valide
    }
        checkFormValidaty();

});


//Active le bouton de validation si touts les champs sont valides
function checkFormValidaty()
{
    // if ( isNameEditValid 
    //    && isAdresseEditValid 
    //    && isTelephoneEditValid 
    //    && isEmailEditValid 
    //    &&photo && photo.type.startsWith("image/") || photoEditpreview.src !== ""
    // btnEditSubmit.removeAttribute("disabled");
    //    && isRoleEditValid) {
        
 }
       
    


//  Reset déplacé hors de checkFormValidaty
document.querySelector("button[type='reset']").addEventListener("click", () => {
    [nomEditInput, adresseEditInput, telephoneEditInput, emailEditInput, photoEditInput, roleEditInput].forEach(input => {
        showError(input, "");
    });
    isNameEditValid 
    isAdresseEditValid = false;
    isTelephoneEditValid = false;
    isEmailEditValid = false;
    isPhotoEditValid = false;
    isRoleEditValid = false;
    btnEditSubmit.disabled = true;
});

frmEditUser.addEventListener("reset", () =>{
     btnEditSubmit.disabled = false;
 });

 
   