    const newPassword = document.getElementById("new_password");
    const confirmePassword = document.getElementById("confirme_password");

    const frmReinitPassWord = document.getElementById("reinitPassWordForm");
    const btnSubmitReinitPassword = document.getElementById("btnSubmitReinit");

    // Desactiver le bouton de soumission par defaut
        btnSubmitReinitPassword.disabled = true;
        
        var isNewPasswordValid = false;
        var isPasswordConfirmValid = false;

    // /Active le bouton de validation si touts les champs sont valides
    function checkFormValidaty()
    {
        if (isNewPasswordValid
            && isPasswordConfirmValid
        ) {
            
        }
        btnSubmitReinitPassword.removeAttribute("disabled");
        }
        
    //Permet d'afficher ou masquer les message d'erreur

    function showError(input, message) {
        const baliseP = input.closest(".form-group").querySelector(".error-message");

        if (message) {
            baliseP.textContent = message;
            input.classList.add("is-invalid");
            // baliseP.style.color = "brown";
            baliseP.style.fontWeight = "bold";
        } else {
            baliseP.textContent = "";
            input.classList.remove("is-invalid");
        }
    }


    // Validation du nouveau mot de passe
    newPassword.addEventListener("input", () => {
        const newPasswordValue = newPassword.value.trim();
        const newPasswordValidator = Validator.passwordValidator("Le passeword", newPasswordValue, 8);

        if (newPasswordValidator) {
            showError(newPassword, newPasswordValidator.message);
            isNewPasswordValid = false;
        }
        else {
            showError(newPassword, "");
           isNewPasswordValid = true;
        }
            checkFormValidaty();
    });

    // Validation du mot de passe confirmation
    confirmePassword.addEventListener("input", () => {
        const confirmePasswordValue = confirmePassword.value.trim();
        const confirmePasswordValidator = Validator.passwordValidator("Le passeword de confirmation", confirmePasswordValue, 8);

        if (confirmePasswordValidator) {
            showError(confirmePassword, confirmePasswordValidator.message);
            isPasswordConfirmValid = false ;
        }
        else if (confirmePasswordValidator != newPassword.value.trim()) {
            showError(confirmePassword, "Les deux mot de passe ne sont pas conformes");
              isPasswordConfirmValid = false ;
        }
        else {
            showError(confirmePassword, "");
             isPasswordConfirmValid = true ;
        }
        checkFormValidaty();
    });

