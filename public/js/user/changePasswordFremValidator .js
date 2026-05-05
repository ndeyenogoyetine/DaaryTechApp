//Récupération des champs du formulair
const currentPassword = document.getElementById("current_password");
const newPassword = document.getElementById("new_password");
const confirmePassword = document.getElementById("confirme_password");


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

// Validation du mot de passe actuel
currentPassword.addEventListener("input", () => {
    const passwordValue = currentPassword.value.trim();
    const currentPasswordValidator = Validator.passwordValidator("Le mot de passe actuel", passwordValue, 8);

    if (currentPasswordValidator) {
        showError(currentPassword, currentPasswordValidator.message);
    }
    else {
        showError(currentPassword, "");
    }
  
});

// Validation du nouveau mot de passe
newPassword.addEventListener("input", () => {
    const newPasswordValue = newPassword.value.trim();
    const newPasswordValidator = Validator.passwordValidator("Le nouveau mot de passe ", newPasswordValue, 8);

    if (newPasswordValidator) {
        showError(newPassword, newPasswordValidator.message);
    }
    else {
        showError(newPassword, "");
    }
  
});

// Validation du mot de passe confirmation
confirmePassword.addEventListener("input", () => {
    const confirmePasswordValue = confirmePassword.value.trim();
    const confirmePasswordValidator = Validator.passwordValidator("Le mot de passe de confirmation", confirmePasswordValue, 8);

    if (confirmePasswordValidator) {
        showError(confirmePassword, confirmePasswordValidator.message);
    }
    else if (confirmePasswordValidator !=  newPassword.value.trim()) {
        showError(confirmePassword, "Les deux mot de passe ne sont pas conformes");
    }
    else {
        showError(confirmePassword, "");
    }
  
});


