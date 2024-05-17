// register_validation.js

function validateForm() {
    // Reset error messages
    document.getElementById("first_name_err").innerText = "";
    document.getElementById("last_name_err").innerText = "";
    document.getElementById("student_card_number_err").innerText = "";
    document.getElementById("email_err").innerText = "";
    document.getElementById("password_err").innerText = "";
    document.getElementById("confirm_password_err").innerText = "";

    // Get form values
    var firstName = document.getElementById("first_name").value.trim();
    var lastName = document.getElementById("last_name").value.trim();
    var studentCardNumber = document.getElementById("student_card_number").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    // Validation
    var isValid = true;
    var errorMsg = "";

    if (firstName === "") {
        errorMsg += "Veuillez entrer votre prénom.\n";
        document.getElementById("first_name_err").innerText = "Veuillez entrer votre prénom.";
        isValid = false;
    }

    if (lastName === "") {
        errorMsg += "Veuillez entrer votre nom.\n";
        document.getElementById("last_name_err").innerText = "Veuillez entrer votre nom.";
        isValid = false;
    }

    if (studentCardNumber === "") {
        errorMsg += "Veuillez entrer votre numéro de carte étudiant.\n";
        document.getElementById("student_card_number_err").innerText = "Veuillez entrer votre numéro de carte étudiant.";
        isValid = false;
    }

    if (email === "") {
        errorMsg += "Veuillez entrer votre adresse email.\n";
        document.getElementById("email_err").innerText = "Veuillez entrer votre adresse email.";
        isValid = false;
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        errorMsg += "Adresse email invalide.\n";
        document.getElementById("email_err").innerText = "Adresse email invalide.";
        isValid = false;
    }

    if (password === "") {
        errorMsg += "Veuillez entrer un mot de passe.\n";
        document.getElementById("password_err").innerText = "Veuillez entrer un mot de passe.";
        isValid = false;
    } else if (password.length < 8) {
        errorMsg += "Le mot de passe doit contenir au moins 8 caractères.\n";
        document.getElementById("password_err").innerText = "Le mot de passe doit contenir au moins 8 caractères.";
        isValid = false;
    }

    if (confirmPassword === "") {
        errorMsg += "Veuillez confirmer le mot de passe.\n";
        document.getElementById("confirm_password_err").innerText = "Veuillez confirmer le mot de passe.";
        isValid = false;
    } else if (password !== confirmPassword) {
        errorMsg += "Les mots de passe ne correspondent pas.\n";
        document.getElementById("confirm_password_err").innerText = "Les mots de passe ne correspondent pas.";
        isValid = false;
    }

    if (!isValid) {
        //alert(errorMsg); // Display error message in a popup
    }

    return isValid;
}
