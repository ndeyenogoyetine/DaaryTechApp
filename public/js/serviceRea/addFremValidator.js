//Récupération des champs du formulair
const nomInput = document.getElementById("nom");
const descriptionInput = document.getElementById("description");
const photoInput = document.getElementById("photo");
const typeInput = document.getElementById("type");
const frmAddRealisation = document.getElementById("addRealisationFrom");
const btnSubmit = frmAddRealisation.querySelector("button[type='submit']");

//Désactive le button de soumission par defaut
btnSubmit.disabled = true;

/*Permet d'afficher ou masquer les message d'erreur
function showError(input, message) {
    const baliseP = input.nextElementSibling;

    if (message) {
        baliseP.textContent = message;
        input.classList.add("is-invalid");
        baliseP.style.color = "brown";
        baliseP.style.fontWeight = "bold";
    }
    else {
        baliseP.textContent = "";
        input.classList.remove("is-invalid");
    }

}*/

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
    }
    else {
        showError(nomInput, "");
    }
    checkFormValidaty();
});

// Validation du champs  Description à la saisie
descriptionInput.addEventListener("input", () => {
    const description = descriptionInput.value.trim();
    const descriptionValidator = Validator.nameValidator("La description", 10, 500, description);
    if (descriptionValidator) {
        showError(descriptionInput, descriptionValidator.message);
    }
    else {
        showError(descriptionInput, "");
    }
    checkFormValidaty();
});

// Validation du champs  photo à la selection
photoInput.addEventListener("change", () => {
    const file = photoInput.files[0];
    if (!file) {
        showError(photoInput, "La photo est obligatoire.");
    }
    else if(!file.type.startsWith("image/")) {
        showError(photoInput, "Le fichier doit ètre une image.");
    }
    else {
        showError(photoInput, "");
    }
    checkFormValidaty();
});


// Validation du champs  type
typeInput.addEventListener("change", () => {
    if (typeInput.value === "") {
        showError(typeInput, "Veuillez slectionner  un type.");
    }
    else {
        showError(typeInput, "");
    }
        checkFormValidaty();

});


//Active le bouton de validation si touts les champs sont valides
 function checkFormValidaty()
{
    const nom = nomInput.value.trim();
    const description = descriptionInput.value.trim();
    const photo = photoInput.files[0];
    const type = typeInput.value.trim();

document.querySelector("button[type='reset']").addEventListener("click", () => {
    [nomInput, descriptionInput, photoInput, typeInput].forEach(input => {
        showError(input, "");
    });
    btnSubmit.disabled = true;
});

const isNameVlide = Validator.nameValidator("Le nom", 5, 40, nom) == null;
const isDescritionValide = Validator.nameValidator("La description", 10, 500, description) == null;
const isPhotoValide =photoInput.files[0]?.type.startsWith("image/");
const isTypeValide = typeInput.value !== "";

btnSubmit.disabled = !(isNameVlide && isDescritionValide && isPhotoValide && isTypeValide);

}
frmAddRealisation.addEventListener("reset", () =>{
     btnSubmit.disabled = true;

 });
  

