const userInput = document.getElementById("id_username")
const passwordInput = document.getElementById("id_password")

userInput.maxLength = 25;
passwordInput.maxLength = 30;

function validateForms() {
    const forms = document.querySelectorAll(".needs-validation");

    Array.from(forms).forEach((form) => {
        form.addEventListener("submit", (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

validateForms();