document.addEventListener('DOMContentLoaded', () => {
  const userInput      = document.getElementById("id_username");
  const nameInput      = document.getElementById("id_name");
  const emailInput     = document.getElementById("id_email");
  const passwordInput  = document.getElementById("id_password");
  const pass2Input     = document.getElementById("id_password_confirm");
  const submitBtn      = document.getElementById("submit_btn");

  userInput.maxLength     = 25;
  nameInput.maxLength     = 225;
  emailInput.maxLength    = 100;
  passwordInput.maxLength = 30;
  pass2Input.maxLength    = 30;

  const reUsername = /^[A-Za-z0-9_]{4,25}$/;
  const reName     = /^[A-Za-zÀ-ÿ ]{1,225}$/;
  const reEmail    = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const rePassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;

  function validateField(input, isValid) {
    if (input.value === "") {
      // se está vazio, limpa todo estado de validação
      input.classList.remove('is-valid', 'is-invalid');
      return;
    }
    input.classList.toggle('is-valid', isValid);
    input.classList.toggle('is-invalid', !isValid);
  }

  // Cada função retorna true/false e já chama validateField
  function validateUsername() {
    const ok = reUsername.test(userInput.value);
    validateField(userInput, ok);
    return ok;
  }
  function validateName() {
    const ok = reName.test(nameInput.value);
    validateField(nameInput, ok);
    return ok;
  }
  function validateEmail() {
    const ok = reEmail.test(emailInput.value);
    validateField(emailInput, ok);
    return ok;
  }
  function validatePassword() {
    const ok = rePassword.test(passwordInput.value);
    validateField(passwordInput, ok);
    return ok;
  }
  function validateConfirm() {
    const ok = passwordInput.value === pass2Input.value && passwordInput.value !== "";
    validateField(pass2Input, ok);
    return ok;
  }

  // Habilita o botão se todos os campos estiverem válidos
  function checkFormValidity() {
    const allValid = [
      validateUsername(),
      validateName(),
      validateEmail(),
      validatePassword(),
      validateConfirm()
    ].every(v => v);
    submitBtn.disabled = !allValid;
  }

  // Em cada digitação, revalida aquele campo e o botão
  [userInput, nameInput, emailInput, passwordInput, pass2Input]
    .forEach(input => input.addEventListener('input', checkFormValidity));

  // Execução inicial
  checkFormValidity();
});
