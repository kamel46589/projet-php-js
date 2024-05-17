function validateRegistrationForm() {
    // Reset error messages
    document.getElementById("first_name_err").innerText = "";
    document.getElementById("last_name_err").innerText = "";
    document.getElementById("email_err").innerText = "";
    document.getElementById("password_err").innerText = "";

    // Get form values
    var firstName = document.getElementById("first_name").value.trim();
    var lastName = document.getElementById("last_name").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value.trim();

    // Validation
    var isValid = true;

    if (firstName === "") {
        document.getElementById("first_name_err").innerText = "Veuillez entrer votre prénom.";
        isValid = false;
    }

    if (lastName === "") {
        document.getElementById("last_name_err").innerText = "Veuillez entrer votre nom.";
        isValid = false;
    }

    if (email === "") {
        document.getElementById("email_err").innerText = "Veuillez entrer votre adresse email.";
        isValid = false;
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        document.getElementById("email_err").innerText = "Adresse email invalide.";
        isValid = false;
    }

    if (password === "") {
        document.getElementById("password_err").innerText = "Veuillez entrer un mot de passe.";
        isValid = false;
    } else if (password.length < 6) {
        document.getElementById("password_err").innerText = "Le mot de passe doit contenir au moins 6 caractères.";
        isValid = false;
    }

    // Check if all fields are provided and valid
    return isValid;
}
function closePopup() {
    valid =validateRegistrationForm()
    if (valid=== true){

    // Get a reference to the last opened popup window
    var popup = window.open('', '_blank');
  
    // This might not work for all browsers, so consider using a library for better compatibility
    if (popup && popup.focus) {
      popup.focus(); // Focus the popup window
      popup.close(); // Close the focused popup window
    }
}
  }