const emailInputLogin = document.getElementById("email");
const passwordInputLogin = document.getElementById("password");
const btnSubmit = document.getElementById("btnSubmit");

// ✅ Vérifie qu'on est bien sur la page login avant d'exécuter
if (emailInputLogin && passwordInputLogin && btnSubmit) {

    // Desactiver le bouton de soumission par defaut
    btnSubmit.disabled = true;

    function showError(input, message) {
        const baliseP = input.nextElementSibling;
        if (message) {
            baliseP.textContent = message;
            input.classList.add("is-invalid");
        } else {
            baliseP.textContent = "";
            input.classList.remove("is-invalid");
        }
    }

    emailInputLogin.addEventListener("input", () => {
        const email = emailInputLogin.value.trim();
        const emailLoginValidator = Validator.emailValidator("L'email", email);
        if (emailLoginValidator) {
            showError(emailInputLogin, emailLoginValidator.message);
        } else {
            showError(emailInputLogin, "");
            checkFormValidaty();
        }
    });

    passwordInputLogin.addEventListener("input", () => {
        const password = passwordInputLogin.value.trim();
        const passwordLoginValidator = Validator.passwordValidator("Le mot de passe", password, 8);
        if (passwordLoginValidator) {
            showError(passwordInputLogin, passwordLoginValidator.message);
            checkFormValidaty();
        } else {
            showError(passwordInputLogin, "");
            checkFormValidaty();
        }
    });

    function checkFormValidaty() {
        const email = emailInputLogin.value.trim();
        const password = passwordInputLogin.value.trim();
        const emailLoginValidator = Validator.emailValidator("L'email", email);
        const passwordLoginValidator = Validator.passwordValidator("Le mot de passe", password, 8);

        if (!emailLoginValidator && !passwordLoginValidator) {
            btnSubmit.disabled = false;
        } else {
            btnSubmit.disabled = true;
        }
    }

}