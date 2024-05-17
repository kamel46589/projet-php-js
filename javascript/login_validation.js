function validateLoginForm() {
    // Reset error messages
    document.getElementById("email_err").innerText = "";
    document.getElementById("password_err").innerText = "";

    // Get form values
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    // Validation
    var isValid = true;

    if (email === "") {
        document.getElementById("email_err").innerText = "Veuillez entrer votre adresse email.";
        isValid = false;
    } else if (email !== "admin@admin" && !/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById("email_err").innerText = "Adresse email invalide.";
        isValid = false;
    }

    if (password === "") {
        document.getElementById("password_err").innerText = "Veuillez entrer un mot de passe.";
        isValid = false;
    }

    // Check if both email and password are provided
    if (!isValid) {
        return false;
    }

    return true;
}
