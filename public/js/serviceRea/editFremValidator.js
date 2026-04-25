//Récupération des champs du formulair
const idInputEdit = document.getElementById("edit-id");
const nomInputEdit = document.getElementById("edit-nom");
const descriptionInputEdit = document.getElementById("edit-description");
const photoInputEdit = document.getElementById("edit-photo");
const typeInputEdit = document.getElementById("edit-type");
const frmEditRealisation = document.getElementById("editRealisationFrom");
const btnSubmitEdit = frmEditRealisation.querySelector("button[type='submit']");
const photoPreview = document.getElementById("photo-preview");

//Désactive le button de soumission par defaut
btnSubmitEdit.disabled = true;

//Permet d'afficher ou masquer les message d'erreur
function showErrorEdit(input, message) {
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
nomInputEdit.addEventListener("input", () => {
    const nom = nomInputEdit.value;
    const nameValidator = Validator.nameValidator("Le nom", 5, 40, nom);

    if (nameValidator) {
        showErrorEdit(nomInputEdit, nameValidator.message);
    }
    else {
        showErrorEdit(nomInputEdit, "");
    }
    checkFormValidatyEdit();
});

// Validation du champs Description à la saisie
descriptionInputEdit.addEventListener("input", () => {
    const description = descriptionInputEdit.value;
    const descriptionValidator = Validator.nameValidator("La description", 10, 500, description);

    if (descriptionValidator) {
        showErrorEdit(descriptionInputEdit, descriptionValidator.message);
    }
    else {
        showErrorEdit(descriptionInputEdit, "");
    }
     checkFormValidatyEdit();
});

 // Validation du champs photo à la selection
photoInputEdit.addEventListener("change", () => {
    const file = photoInputEdit.files[0];

    if (!file && !photoPreview.src) {
        showErrorEdit(photoInputEdit, "La photo est obligatoire.");
    }
    else if (!file.type.startsWith("image/")) {
        showErrorEdit(photoInputEdit, "Le fichier doit être une image.");
    }
    else {
        showErrorEdit(photoInputEdit, "");
    }
    checkFormValidatyEdit();
});

// Validation du champs type
  var photoChange = "";
typeInputEdit.addEventListener("change", () => {
    if (typeInputEdit.value === "") {
        showErrorEdit(typeInputEdit, "Veuillez sélectionner un type.");
    }
    else {
        showErrorEdit(typeInputEdit, "");
    }
       checkFormValidatyEdit();
});


//Active le bouton de validation si touts les champs sont valides
function checkFormValidatyEdit() {
    const nom = nomInputEdit.value;
    const description = descriptionInputEdit.value;
    const photo = photoInputEdit.files[0];
    const type = typeInputEdit.value.trim();

    const isNameValide = Validator.nameValidator("Le nom", 5, 40, nom) == null;
    const isDescriptionValide = Validator.nameValidator("La description", 10, 500, description) == null;
    const isPhotoValide = (photo && photo.type.startsWith("image/")) || !photoPreview.src;
    const isTypeValide = type !== "";

    btnSubmitEdit.disabled = !(isNameValide && isDescriptionValide && isPhotoValide && isTypeValide);
}

// Réinitialisation du formulaire

    const editButons = document.querySelectorAll(".btn-edit");

    editButons.forEach(button => {
    button.addEventListener("click", () => {
        const id = button.getAttribute("data-id");
        const nom = button.getAttribute("data-nom");
        const description = button.getAttribute("data-description");
        const type = button.getAttribute("data-type");
        const photo = button.getAttribute("data-photo");
        photoChange = photo;

        // Remplir les champs du formulaire
        idInputEdit.value = id;
        nomInputEdit.value = nom;
        descriptionInputEdit.value = description;
        typeInputEdit.value = type;

        // Mettre à jour l'aperçu de la photo
        if (photo) {
            photoPreview.src = `public/images/servicesRea/${photo}`;
            photoPreview.style.display = "block";
        } else {
            photoPreview.src = `public/images/servicesRea/default.jpg`;
        }

        // Réactiver le bouton après remplissage
        checkFormValidatyEdit();
    });
});


