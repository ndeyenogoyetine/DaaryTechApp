class Validator 
{

    //Permet de valider un mot de passe
    static passwordValidator(controlName, value, lengthword) {
        return !value.length

            ? { error: true, message: `${controlName} est obligatoire.` }
            : value.length < lengthword
                ? { error: true, message: `${controlName}  doit contenir au moins ${lengthword} chiffires.` }
                : ((value != "") && (value.startsWith(" ") || value.endsWith(" ")))
                    ? { error: true, message: `Les espaces de debut et de fin ne sont pas autorisés.` }
                    : null;
    }

    //Permet de valider une adresse email
    static emailValidator(controlName, value) {
        let pattern = '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,4}$';

        return !value.length
            ? { error: true, message: `${controlName} est obligatoire` }
            : !value.match(new RegExp(pattern))
                ? { error: true, message: `${controlName} doit respecter le format exmple@gmail.com.` }
                : null;
    }

    //Permet de valider une numéro de téléphone
    static phoneValidator(controlName, minlength, maxlength, value) {
        let pattern = '^[0-9]+(\.[0-9]+?)$';

        return !value.length
            ? { error: true, message: `${controlName} est obligatoire.` }
            : !value.match(new RegExp(pattern))
                ? { error: true, message: `${controlName} ne doit contenir que des chiffires.` }
                : value.length < minlength
                    ? { error: true, message: `${controlName}  doit contenir au moins ${minlength} chiffires.` }
                    : value.length > maxlength
                        ? { error: true, message: `${controlName}  doit contenir au plus ${maxlength} chiffires.` }
                        : null;
    }

    //Permet de valider un nom composer de chaine de caractére
    static nameValidator(controlName, minlength, maxlength, value) {
     let pattern = /^[A-Za-zÀ-ÿ\'\- ]+$/;
        if (!value) {
            return { error: true, message: `${controlName} est obligatoire.` }
        }

        if (!value.match(new RegExp(pattern))) {
            return { error: true, message: `${controlName} ne doit contenir que des lettres.` }
        }

        if (value.length < minlength) {
            return { error: true, message: `${controlName}  doit contenir au moins ${minlength} lettres.` }

        }

        if (value.length > maxlength) {
            return { error: true, message: `${controlName}  doit contenir au plus ${maxlength} lettres.` }

        }


        if ((value != "") && (value.startsWith(" ") || value.endsWith(" "))) {
            return { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` }

        }
        return null;
    }

    //Permet de valider une adresse
    static adresseValidator(controlName, minlength, maxlength, value) {
        const isContainsNumber = /^(?=.*[0-9]).*$/;
        const isContainsUpperCase = /^(?=.*[A-Z]).*$/;
        const isContainsLowerCase = /^(?=.*[0-9]).*$/;
        const isContainsSymbol = /^(?=.*[-,;]).*$/;

        if (!value) {
            return { error: true, message: `${controlName} est obligatoire` }
        }

        if (isContainsSymbol.test(value)
            && !isContainsNumber.test(value)
            && !isContainsUpperCase.test(value)
            && !isContainsLowerCase.test(value)) {
            return { error: true, message: `${controlName} ne doit pas contenir que des caractères spéciaux.` }
        }

        if (isContainsNumber.test(value)
            && !isContainsSymbol.test(value)
            && !isContainsUpperCase.test(value)
            && !isContainsLowerCase.test(value)) {
            return { error: true, message: `${controlName} ne doit pas contenir que des chiffres.` }
        }

        if (value.length < minlength) {
            return { error: true, message: `${controlName}  doit contenir au moins ${minlength} lettres.` }

        }

        if (value.length > maxlength) {
            return { error: true, message: `${controlName}  doit contenir au plus ${maxlength} lettres.` }

        }

        if ((value != "") && (value.startsWith(" ") || value.endsWith(" "))) {
            return { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` }

        }
        return null;
    }
}