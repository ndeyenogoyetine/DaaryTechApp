const frmConfirmMail = document.getElementById("reinitConfirmMailForm");

if (frmConfirmMail) {

    const emailInputReinit = document.getElementById("confirmEmailReinit");
    const btnConfirmMailSubmit = frmConfirmMail.querySelector("button[type='submit']");

    let isEmailConfirmValid = false;

    // Désactive le bouton de soumission par défaut
    btnConfirmMailSubmit.disabled = true;

    // Permet d'afficher ou masquer les messages d'erreur
    function showError(input, message) {
        const baliseP = input.closest(".form-group").querySelector(".error-message");

        if (message) {
            baliseP.textContent = message;
            input.classList.add("is-invalid");
            baliseP.style.fontWeight = "bold";
        } else {
            baliseP.textContent = "";
            input.classList.remove("is-invalid");
        }
    }

    // Active ou désactive le bouton selon la validité du formulaire
    function checkFormValidaty() {
        if (isEmailConfirmValid) {
            btnConfirmMailSubmit.removeAttribute("disabled");
        } else {
            btnConfirmMailSubmit.disabled = true;
        }
    }

    // Validation du champ email à la saisie
    emailInputReinit.addEventListener("input", () => {
        const email = emailInputReinit.value.trim();
        const emailValidator = Validator.emailValidator("L'email", email);

        if (emailValidator) {
            showError(emailInputReinit, emailValidator.message);
            isEmailConfirmValid = false;
        } else {
            showError(emailInputReinit, "");
            isEmailConfirmValid = true;
        }
        checkFormValidaty();
    });

}